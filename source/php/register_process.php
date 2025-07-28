<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'DBManager.php';

$error = '';
$redirectUrl = $_POST['redirect'] ?? 'home.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $account  = trim($_POST['account'] ?? '');
    $password = $_POST['password'] ?? '';
    $postcode = trim($_POST['postcode'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $mail     = trim($_POST['mail'] ?? '');

    // 入力値を保持（パスワードは除く）
    $old = [
        'name' => $name,
        'account' => $account,
        'postcode' => $postcode,
        'address' => $address,
        'phone' => $phone,
        'mail' => $mail
    ];

    if ($name === '' || $account === '' || $password === '' || $postcode === '' || $address === '' || $phone === '' || $mail === '') {
        $error = 'すべての項目を入力してください。';
    } else {
        $pdo = getDB();

        // アカウント重複チェック
        $stmt = $pdo->prepare("SELECT * FROM ec_user WHERE account = ?");
        $stmt->execute([$account]);
        if ($stmt->fetch()) {
            $error = 'このアカウント名は既に使用されています。';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO ec_user (name, account, password, postcode, address, phone, mail) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $account, $hashedPassword, $postcode, $address, $phone, $mail]);

            // セッションに保存（ログイン状態に）
            $_SESSION['user'] = [
                'id'      => $pdo->lastInsertId(),
                'name'    => $name,
                'account' => $account,
            ];

            // 登録成功 → 指定されたリダイレクト先へ
            header('Location: ' . $redirectUrl);
            exit;
        }
    }

    // エラーがあった場合、register.phpに入力値と共に戻す
    $redirectParams = [
        'error' => urlencode($error),
        'redirect' => urlencode($redirectUrl),
        'old' => urlencode(json_encode($old))
    ];
    $url = 'register.php?' . http_build_query($redirectParams);
    header("Location: $url");
    exit;
}
