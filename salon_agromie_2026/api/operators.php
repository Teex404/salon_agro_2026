<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/auth.php';

$action = $_GET['action'] ?? '';

if ($action === 'start_session') {
    requirePost();
    requireRoles(['stand_manager', 'event_manager']);

    $fullName = trim($_POST['operator_full_name'] ?? '');
    $promotion = trim($_POST['operator_promotion'] ?? '');

    if ($fullName === '' || $promotion === '') {
        jsonResponse(false, null, 'Nom complet et promotion obligatoires.');
    }

    $role = $_SESSION['role'];
    $userId = (int)$_SESSION['user_id'];
    $standId = $_SESSION['stand_id'] ? (int)$_SESSION['stand_id'] : null;
    $eventId = $_SESSION['event_id'] ? (int)$_SESSION['event_id'] : null;
    $context = $role === 'stand_manager' ? 'stand' : 'event';

    $stmt = $pdo->prepare("
        INSERT INTO operator_sessions
        (user_id, operator_full_name, operator_promotion, operator_role_context, stand_id, event_id)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$userId, $fullName, $promotion, $context, $standId, $eventId]);

    $_SESSION['operator_session_id'] = (int)$pdo->lastInsertId();
    $_SESSION['operator_full_name'] = $fullName;
    $_SESSION['operator_promotion'] = $promotion;

    jsonResponse(true, [
        'redirect' => $role === 'stand_manager' ? '../stand/index.php' : '../event/index.php'
    ]);
}

jsonResponse(false, null, 'Action inconnue.');