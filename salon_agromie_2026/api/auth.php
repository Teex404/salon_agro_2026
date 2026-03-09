<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/auth.php';

$action = $_GET['action'] ?? '';

if ($action === 'login') {
    requirePost();

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        jsonResponse(false, null, 'Veuillez remplir les champs.');
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND is_active = 1 LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        jsonResponse(false, null, 'Identifiants invalides.');
    }

    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['stand_id'] = $user['stand_id'];
    $_SESSION['event_id'] = $user['event_id'];

    jsonResponse(true, [
        'role' => $user['role'],
        'redirect' => match ($user['role']) {
            'admin' => '../admin/dashboard.php',
            'stand_manager' => '../stand/login.php',
            'event_manager' => '../event/login.php',
            default => '../index.php'
        }
    ]);
}

if ($action === 'logout') {
    session_destroy();
    jsonResponse(true, ['redirect' => '../index.php']);
}

if ($action === 'me') {
    requireLogin();
    jsonResponse(true, [
        'user_id' => $_SESSION['user_id'],
        'username' => $_SESSION['username'],
        'role' => $_SESSION['role'],
        'stand_id' => $_SESSION['stand_id'] ?? null,
        'event_id' => $_SESSION['event_id'] ?? null,
        'operator_session_id' => $_SESSION['operator_session_id'] ?? null,
        'operator_full_name' => $_SESSION['operator_full_name'] ?? null,
        'operator_promotion' => $_SESSION['operator_promotion'] ?? null
    ]);
}

jsonResponse(false, null, 'Action inconnue.');