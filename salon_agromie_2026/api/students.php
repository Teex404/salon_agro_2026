<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/auth.php';

$action = $_GET['action'] ?? '';

if ($action === 'create') {
    requirePost();
    requireRole('admin');

    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $promotion = trim($_POST['promotion'] ?? '');

    if ($firstName === '' || $lastName === '' || $promotion === '') {
        jsonResponse(false, null, 'Tous les champs sont obligatoires.');
    }

    $qrToken = generateToken(24);

    $stmt = $pdo->prepare("
        INSERT INTO students (first_name, last_name, promotion, qr_token)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$firstName, $lastName, $promotion, $qrToken]);

    jsonResponse(true, [
        'id' => $pdo->lastInsertId(),
        'qr_token' => $qrToken
    ]);
}

if ($action === 'list') {
    requireLogin();

    $stmt = $pdo->query("
        SELECT 
            s.*,
            COALESCE(SUM(p.points), 0) AS total_points
        FROM students s
        LEFT JOIN points p ON p.student_id = s.id
        GROUP BY s.id
        ORDER BY s.last_name ASC, s.first_name ASC
    ");
    jsonResponse(true, $stmt->fetchAll());
}

if ($action === 'find_by_token') {
    requireRoles(['admin', 'stand_manager', 'event_manager']);

    $token = trim($_GET['t'] ?? '');
    if ($token === '') {
        jsonResponse(false, null, 'Token manquant.');
    }

    $stmt = $pdo->prepare("
        SELECT 
            s.*,
            COALESCE(SUM(p.points), 0) AS total_points
        FROM students s
        LEFT JOIN points p ON p.student_id = s.id
        WHERE s.qr_token = ? AND s.is_active = 1
        GROUP BY s.id
        LIMIT 1
    ");
    $stmt->execute([$token]);
    $student = $stmt->fetch();

    if (!$student) {
        jsonResponse(false, null, 'Étudiant introuvable.');
    }

    jsonResponse(true, $student);
}

jsonResponse(false, null, 'Action inconnue.');