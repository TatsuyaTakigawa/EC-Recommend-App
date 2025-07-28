<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'DBManager.php';

// ログインチェック
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['id'];
$cartId = filter_input(INPUT_POST, 'cart_id', FILTER_VALIDATE_INT);
$redirect = $_POST['redirect'] ?? 'cart.php'; // デフォルトはカート画面へ

// バリデーション
if (!$cartId) {
    header('Location: ' . $redirect);
    exit;
}

try {
    $pdo = getDB();

    // 削除対象がログインユーザーのカートにあるか確認
    $stmt = $pdo->prepare("SELECT id FROM ec_cart WHERE id = ? AND userid = ?");
    $stmt->execute([$cartId, $userId]);
    $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cartItem) {
        // 該当カート商品を削除
        $stmt = $pdo->prepare("DELETE FROM ec_cart WHERE id = ?");
        $stmt->execute([$cartId]);
    }

    // 処理後に元のページにリダイレクト
    header('Location: ' . $redirect);
    exit;
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: ' . $redirect);
    exit;
}
