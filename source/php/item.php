<?php
include 'header.php';
require_once 'DBManager.php';


// GETパラメータのバリデーション
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<p>不正なアクセスです。</p>';
    include 'footer.php';
    exit;
}

$itemId = (int)$_GET['id'];

try {
    $pdo = getDB();

    $sql = "
        SELECT 
            i.*, 
            c.name AS country_name, 
            m.name AS menthol_flag_name
        FROM ec_item i
        LEFT JOIN country c ON i.country_id = c.id
        LEFT JOIN menthol_flag m ON i.menthol_flag_id = m.id
        WHERE i.id = :id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item) {
        echo '<p>該当する商品が見つかりませんでした。</p>';
        include 'footer.php';
        exit;
    }
} catch (PDOException $e) {
    echo '<p>エラーが発生しました: ' . htmlspecialchars($e->getMessage()) . '</p>';
    include 'footer.php';
    exit;
}
?>

<link rel="stylesheet" href="../css/item.css">
<main class="item-detail">
    <h2 class="item-detail__title"><?= htmlspecialchars($item['name']) ?></h2>
    <div class="item-detail__container">
        <img src="../itemimg/<?= htmlspecialchars($item['image_filename']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="item-detail__image" style="max-width:300px;">
        <div class="item-detail__info">
            <p><strong>価格：</strong><?= htmlspecialchars($item['price']) ?>円</p>
            <p><strong>タール：</strong><?= htmlspecialchars($item['tar']) ?>mg</p>
            <p><strong>ニコチン：</strong><?= htmlspecialchars($item['nicotine']) ?>mg</p>
            <p><strong>入数：</strong><?= htmlspecialchars($item['quantity']) ?>本</p>
            <p><strong>原産国：</strong><?= htmlspecialchars($item['country_name']) ?></p>
            <p><strong>タイプ：</strong><?= htmlspecialchars($item['menthol_flag_name']) ?></p>
            <form method="post" action="cart_add.php" class="item-detail__form">
                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                <label for="quantity">数量:</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= htmlspecialchars($item['quantity']) ?>" class="item-detail__input-quantity">
                <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <button type="submit" class="item-detail__btn-add-cart">カートに追加</button>
            </form>
            <p><a href="cart.php" class="item-detail__link">カートを確認する</a></p>
            <p><a href="home.php" class="item-detail__link">商品一覧に戻る</a></p>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
