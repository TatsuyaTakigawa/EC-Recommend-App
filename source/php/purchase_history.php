<?php
include 'header.php';
require_once 'DBManager.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$userId = $_SESSION['user']['id'];

// 購入履歴取得（ec_purchaseとec_itemを結合）
$stmt = $pdo->prepare("
    SELECT p.id, p.date, i.name, i.price
    FROM ec_purchase p
    JOIN ec_item i ON p.itemid = i.id
    WHERE p.userid = ?
    ORDER BY p.date DESC
");
$stmt->execute([$userId]);
$histories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../css/purchase_history.css">
<main class="purchase-history-main">
    <h2 class="purchase-history-title">購入履歴</h2>

    <?php if (empty($histories)): ?>
        <p class="purchase-history-empty">購入履歴はありません。</p>
    <?php else: ?>
        <ul class="purchase-history-list">
            <?php foreach ($histories as $history): ?>
                <li class="purchase-history-item">
                    <span class="item-name"><?= htmlspecialchars($history['name']) ?></span>
                    <span class="item-price"><?= htmlspecialchars($history['price']) ?>円</span>
                    <span class="item-date"><?= htmlspecialchars($history['date']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
