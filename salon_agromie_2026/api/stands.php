<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/auth.php';

$action = $_GET['action'] ?? '';

if ($action === 'create') {
    requirePost();
    requireRole('admin');

    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location = trim($_POST['location_label'] ?? '');
    $points = (int)($_POST['points_per_visit'] ?? 5);

    if ($name === '') {
        jsonResponse(false, null, 'Nom du stand obligatoire.');
    }

    $stmt = $pdo->prepare("
        INSERT INTO stands (name, description, location_label, points_per_visit)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$name, $description, $location, $points]);

    jsonResponse(true, ['id' => $pdo->lastInsertId()]);
}

if ($action === 'list') {
    requireLogin();
    $stmt = $pdo->query("SELECT * FROM stands ORDER BY name ASC");
    jsonResponse(true, $stmt->fetchAll());
}

jsonResponse(false, null, 'Action inconnue.');