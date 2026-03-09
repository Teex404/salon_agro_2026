<?php

function requireLogin(): void {
    if (empty($_SESSION['user_id'])) {
        jsonResponse(false, null, 'Session non connectée.');
    }
}

function requireRole(string $role): void {
    requireLogin();
    if (($_SESSION['role'] ?? '') !== $role) {
        jsonResponse(false, null, 'Accès refusé.');
    }
}

function requireRoles(array $roles): void {
    requireLogin();
    if (!in_array($_SESSION['role'] ?? '', $roles, true)) {
        jsonResponse(false, null, 'Accès refusé.');
    }
}