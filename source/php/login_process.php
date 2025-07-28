<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'DBManager.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$input    = trim($_POST['account'] ?? '');
$password = $_POST['password'] ?? '';
$redirect = $_POST['redirect'] ?? 'home.php';

// 入力チェック
if ($input === '' || $password === '') {
    $error = 'アカウント名（またはメール）とパスワードを入力してください。';
    header('Location: login.php?error=' . urlencode($error) . '&redirect=' . urlencode($redirect));
    exit;
}

$pdo = getDB();

$stmt = $pdo->prepare('SELECT * FROM ec_user WHERE account = ? OR mail = ?');
$stmt->execute([$input, $input]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // ログイン成功
    $_SESSION['user'] = [
        'id'      => $user['id'],
        'name'    => $user['name'],
        'account' => $user['account'],
        'mail'    => $user['mail']
    ];

    // login.php に戻ろうとする場合は home.php に変更（無限ループ防止）
    if (strpos($redirect, 'login.php') !== false) {
        $redirect = 'home.php';
    }

    header('Location: ' . $redirect);
    exit;
} else {
    $error = 'アカウント名（またはメール）またはパスワードが正しくありません。';
    header('Location: login.php?error=' . urlencode($error) . '&redirect=' . urlencode($redirect));
    exit;
}
