<?php
require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/auth.php';

requireRole('admin');

$action = $_GET['action'] ?? '';

if ($action === 'stats') {
    $data = [
        'total_students' => (int)$pdo->query("SELECT COUNT(*) FROM students")->fetchColumn(),
        'total_stands' => (int)$pdo->query("SELECT COUNT(*) FROM stands")->fetchColumn(),
        'total_events' => (int)$pdo->query("SELECT COUNT(*) FROM events")->fetchColumn(),
        'total_stand_visits' => (int)$pdo->query("SELECT COUNT(*) FROM stand_visits")->fetchColumn(),
        'total_event_attendance' => (int)$pdo->query("SELECT COUNT(*) FROM event_attendance")->fetchColumn(),
        'total_points' => (int)$pdo->query("SELECT COALESCE(SUM(points),0) FROM points")->fetchColumn(),
        'total_attendance' => (int)$pdo->query("SELECT COUNT(*) FROM attendance")->fetchColumn(),
        'total_event_codes' => 0
    ];

    jsonResponse(true, $data);
}

if ($action === 'visits_by_stand') {
    $stmt = $pdo->query("
        SELECT s.name AS stand_name, COUNT(v.id) AS total_visits
        FROM stands s
        LEFT JOIN stand_visits v ON v.stand_id = s.id
        GROUP BY s.id, s.name
        ORDER BY total_visits DESC, s.name ASC
    ");
    jsonResponse(true, $stmt->fetchAll());
}

if ($action === 'attendance_trend') {
    $stmt = $pdo->query("
        SELECT DATE(attended_at) AS day_label, COUNT(*) AS total_count
        FROM attendance
        GROUP BY DATE(attended_at)
        ORDER BY DATE(attended_at) ASC
    ");
    jsonResponse(true, $stmt->fetchAll());
}

if ($action === 'recent_activity') {
    $recentVisits = $pdo->query("
        SELECT
            CONCAT(st.last_name, ' ', st.first_name) AS student_name,
            st.promotion,
            sd.name AS stand_name,
            sv.visited_at
        FROM stand_visits sv
        INNER JOIN students st ON st.id = sv.student_id
        INNER JOIN stands sd ON sd.id = sv.stand_id
        ORDER BY sv.visited_at DESC
        LIMIT 8
    ")->fetchAll();

    $recentAttendance = $pdo->query("
        SELECT
            CONCAT(st.last_name, ' ', st.first_name) AS student_name,
            st.promotion,
            ea.attended_at
        FROM event_attendance ea
        INNER JOIN students st ON st.id = ea.student_id
        ORDER BY ea.attended_at DESC
        LIMIT 8
    ")->fetchAll();

    jsonResponse(true, [
        'recent_visits' => $recentVisits,
        'recent_attendance' => $recentAttendance
    ]);
}

jsonResponse(false, null, 'Action inconnue.');