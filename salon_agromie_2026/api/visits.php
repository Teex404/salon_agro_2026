<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/auth.php';

$action = $_GET['action'] ?? '';

if ($action === 'scan_stand') {
    requirePost();
    requireRole('stand_manager');

    $token = trim($_POST['qr_token'] ?? '');
    if ($token === '') {
        jsonResponse(false, null, 'QR token obligatoire.');
    }

    $userId = (int)$_SESSION['user_id'];
    $standId = (int)($_SESSION['stand_id'] ?? 0);
    $operatorSessionId = (int)($_SESSION['operator_session_id'] ?? 0);

    if ($standId <= 0 || $operatorSessionId <= 0) {
        jsonResponse(false, null, 'Session opérateur invalide.');
    }

    $stmtStudent = $pdo->prepare("
        SELECT * 
        FROM students 
        WHERE qr_token = ? AND is_active = 1 
        LIMIT 1
    ");
    $stmtStudent->execute([$token]);
    $student = $stmtStudent->fetch();

    if (!$student) {
        jsonResponse(false, null, 'Étudiant introuvable.');
    }

    $today = date('Y-m-d');

    $stmtCheck = $pdo->prepare("
        SELECT id 
        FROM stand_visits
        WHERE student_id = ? AND stand_id = ? AND visit_date = ?
        LIMIT 1
    ");
    $stmtCheck->execute([$student['id'], $standId, $today]);

    if ($stmtCheck->fetch()) {
        jsonResponse(false, null, 'Étudiant déjà validé aujourd’hui pour ce stand.');
    }

    $stmtStand = $pdo->prepare("
        SELECT * 
        FROM stands 
        WHERE id = ? 
        LIMIT 1
    ");
    $stmtStand->execute([$standId]);
    $stand = $stmtStand->fetch();

    if (!$stand) {
        jsonResponse(false, null, 'Stand introuvable.');
    }

    try {
        $pdo->beginTransaction();

        $stmtVisit = $pdo->prepare("
            INSERT INTO stand_visits (
                student_id,
                stand_id,
                scanned_by_user_id,
                operator_session_id,
                visit_date
            ) VALUES (?, ?, ?, ?, ?)
        ");
        $stmtVisit->execute([
            $student['id'],
            $standId,
            $userId,
            $operatorSessionId,
            $today
        ]);

        $stmtPoints = $pdo->prepare("
            INSERT INTO points (
                student_id,
                source_type,
                source_id,
                points,
                awarded_by_user_id,
                operator_session_id,
                note
            ) VALUES (?, 'stand', ?, ?, ?, ?, ?)
        ");
        $stmtPoints->execute([
            $student['id'],
            $standId,
            (int)$stand['points_per_visit'],
            $userId,
            $operatorSessionId,
            'Points attribués pour visite du stand'
        ]);

        $pdo->commit();

        jsonResponse(true, [
            'student_name' => $student['last_name'] . ' ' . $student['first_name'],
            'promotion' => $student['promotion'],
            'stand_name' => $stand['name'],
            'points_added' => (int)$stand['points_per_visit']
        ]);
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        jsonResponse(false, null, 'Erreur lors de l’enregistrement de la visite.');
    }
}

jsonResponse(false, null, 'Action inconnue.');