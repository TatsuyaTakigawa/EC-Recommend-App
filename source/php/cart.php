<?php
include 'header.php';
require_once 'DBManager.php';

if (!isset($_SESSION['user'])) {
    echo '<p>カートを表示するにはログインが必要です。</p>';
    include 'footer.php';
    exit;
}

$userId = $_SESSION['user']['id'];
$pdo = getDB();

$stmt = $pdo->prepare("
    SELECT ec_cart.id AS cart_id, ec_item.*, ec_cart.quantity
    FROM ec_cart
    JOIN ec_item ON ec_cart.itemid = ec_item.id
    WHERE ec_cart.userid = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<link rel="stylesheet" href="../css/cart.css">
<main class="cart">
    <h1>ショッピングカート</h1>

    <?php if (count($cartItems) === 0): ?>
        <p>カートに商品はありません。</p>
    <?php else: ?>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>数量</th>
                    <th>小計</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cartItems as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><img src="../itemimg/<?= htmlspecialchars($item['image_filename']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" width="80"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['price']) ?>円</td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td><?= $subtotal ?>円</td>
                    <td>
                        <form action="cart_delete.php" method="post">
                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                            <input type="hidden" name="redirect" value="cart.php">
                            <button type="submit">削除</button>
                        </form>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p class="cart-total"><strong>合計金額：</strong><?= $total ?>円</p>

        <form action="purchase_confirm.php" method="post">
            <button type="submit">購入へ進む</button>
        </form>
    <?php endif; ?>
</main>

<?php include 'footer.php'; ?>
