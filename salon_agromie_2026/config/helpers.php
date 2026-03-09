<?php

function jsonResponse(bool $ok, $data = null, ?string $error = null): void {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok' => $ok,
        'data' => $data,
        'error' => $error
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function requirePost(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(false, null, 'Méthode non autorisée.');
    }
}

function generateToken(int $length = 32): string {
    return bin2hex(random_bytes($length / 2));
}