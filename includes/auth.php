<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in() {
    return !empty($_SESSION['user']);
}

function is_admin() {
    return is_logged_in() && (($_SESSION['user']['role'] ?? 'user') === 'admin');
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_admin() {
    if (!is_admin()) {
        header('Location: index.php?status=forbidden');
        exit;
    }
}
