<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['sesskey'])) {
    $_SESSION['sesskey'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../vendor/autoload.php';
