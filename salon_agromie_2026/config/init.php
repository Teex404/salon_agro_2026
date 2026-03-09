<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Indian/Antananarivo');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';