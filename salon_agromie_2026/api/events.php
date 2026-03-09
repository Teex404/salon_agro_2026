<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/auth.php';

$action = $_GET['action'] ?? '';

if ($action === 'create') {
    requirePost();
    requireRole('admin');

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location = trim($_POST['location_label'] ?? '');
    $startAt = trim($_POST['start_at'] ?? '');
    $endAt = trim($_POST['end_at'] ?? '');
    $points = (int)($_POST['points_reward'] ?? 20);

    if ($title === '') {
        jsonResponse(false, null, 'Titre obligatoire.');
    }

    $stmt = $pdo->prepare("
        INSERT INTO events (title, description, location_label, start_at, end_at, points_reward)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$title, $description, $location, $startAt ?: null, $endAt ?: null, $points]);

    jsonResponse(true, ['id' => $pdo->lastInsertId()]);
}

if ($action === 'list') {
    requireLogin();
    $stmt = $pdo->query("SELECT * FROM events ORDER BY start_at ASC, title ASC");
    jsonResponse(true, $stmt->fetchAll());
}

jsonResponse(false, null, 'Action inconnue.');

if ($action === 'scan_event') {
    requirePost();
    requireRole('event_manager');

    $token = trim($_POST['qr_token'] ?? '');
    if ($token === '') {
        jsonResponse(false, null, 'QR token obligatoire.');
    }

    $userId = (int)$_SESSION['user_id'];
    $eventId = (int)($_SESSION['event_id'] ?? 0);
    $operatorSessionId = (int)($_SESSION['operator_session_id'] ?? 0);

    if ($eventId <= 0 || $operatorSessionId <= 0) {
        jsonResponse(false, null, 'Session opérateur invalide.');
    }

    $stmtStudent = $pdo->prepare("SELECT * FROM students WHERE qr_token = ? AND is_active = 1 LIMIT 1");
    $stmtStudent->execute([$token]);
    $student = $stmtStudent->fetch();

    if (!$student) {
        jsonResponse(false, null, 'Étudiant introuvable.');
    }

    $stmtCheck = $pdo->prepare("
        SELECT id FROM event_attendance
        WHERE student_id = ? AND event_id = ?
        LIMIT 1
    ");
    $stmtCheck->execute([$student['id'], $eventId]);

    if ($stmtCheck->fetch()) {
        jsonResponse(false, null, 'Étudiant déjà validé pour cette conférence.');
    }

    $stmtEvent = $pdo->prepare("SELECT * FROM events WHERE id = ? LIMIT 1");
    $stmtEvent->execute([$eventId]);
    $event = $stmtEvent->fetch();

    if (!$event) {
        jsonResponse(false, null, 'Conférence introuvable.');
    }

    $pdo->beginTransaction();

    $stmtAttendance = $pdo->prepare("
        INSERT INTO event_attendance (student_id, event_id, scanned_by_user_id, operator_session_id)
        VALUES (?, ?, ?, ?)
    ");
    $stmtAttendance->execute([$student['id'], $eventId, $userId, $operatorSessionId]);

    $stmtPoints = $pdo->prepare("
        INSERT INTO points (student_id, source_type, source_id, points, awarded_by_user_id, operator_session_id, note)
        VALUES (?, 'event', ?, ?, ?, ?, ?)
    ");
    $stmtPoints->execute([
        $student['id'],
        $eventId,
        (int)$event['points_reward'],
        $userId,
        $operatorSessionId,
        'Points attribués pour participation à une conférence'
    ]);

    $pdo->commit();

    jsonResponse(true, [
        'student_name' => $student['last_name'] . ' ' . $student['first_name'],
        'promotion' => $student['promotion'],
        'event_title' => $event['title'],
        'points_added' => (int)$event['points_reward']
    ]);
}