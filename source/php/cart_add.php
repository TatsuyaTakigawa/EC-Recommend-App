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
$itemId = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
$quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
$redirect = $_POST['redirect'] ?? 'home.php';

// バリデーション
if (!$itemId || !$quantity || $quantity < 1) {
    // 不正リクエスト時は元ページに戻す
    header('Location: ' . $redirect);
    exit;
}

try {
    $pdo = getDB();

    // 既にカートに同じ商品があれば数量を更新
    $stmt = $pdo->prepare("SELECT quantity FROM ec_cart WHERE userid = ? AND itemid = ?");
    $stmt->execute([$userId, $itemId]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        $newQuantity = $existing['quantity'] + $quantity;
        $stmt = $pdo->prepare("UPDATE ec_cart SET quantity = ? WHERE userid = ? AND itemid = ?");
        $stmt->execute([$newQuantity, $userId, $itemId]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO ec_cart (userid, itemid, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $itemId, $quantity]);
    }

    // 正常に追加完了後は元のページへリダイレクト
    header('Location: ' . $redirect);
    exit;
} catch (PDOException $e) {
    error_log($e->getMessage());
    // エラー時も元のページに戻す
    header('Location: ' . $redirect);
    exit;
}
