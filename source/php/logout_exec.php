<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['confirm'] ?? '') === 'yes') {
    // セッションのユーザ情報を空にして、セッション破棄
    unset($_SESSION['user']);
    session_destroy();

    header('Location: home.php');
    exit;
} else {
    header('Location: home.php');
    exit;
}
