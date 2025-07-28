<?php
include 'header.php';
require_once 'DBManager.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$userId = $_SESSION['user']['id'];

// カート内容取得
$stmt = $pdo->prepare("
    SELECT c.itemid, i.name, i.price
    FROM ec_cart c
    JOIN ec_item i ON c.itemid = i.id
    WHERE c.userid = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
if (!empty($cartItems)) {
    $total = array_sum(array_column($cartItems, 'price'));
}

// 購入処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $total > 0) {
    try {
        $pdo->beginTransaction();

        $insert = $pdo->prepare("INSERT INTO ec_purchase (userid, itemid, date) VALUES (?, ?, NOW())");

        foreach ($cartItems as $item) {
            $insert->execute([$userId, $item['itemid']]);
        }

        // カートを空に
        $pdo->prepare("DELETE FROM ec_cart WHERE userid = ?")->execute([$userId]);

        $pdo->commit();

        header('Location: purchase_history.php');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo '<p>購入処理中にエラーが発生しました。再度お試しください。</p>';
        error_log($e->getMessage());
    }
}
?>

<main class="purchase">
    <h2>購入手続き</h2>

    <?php if (empty($cartItems)): ?>
        <p>カートに商品がありません。</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cartItems as $item): ?>
                <li><?= htmlspecialchars($item['name']) ?> - <?= htmlspecialchars($item['price']) ?>円</li>
            <?php endforeach; ?>
        </ul>

        <p><strong>合計金額：<?= $total ?>円</strong></p>

        <form action="purchase.php" method="post">
            <button type="submit">購入を確定する</button>
        </form>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
