<?php
include 'header.php';
require_once 'DBManager.php';
?>

<link rel="stylesheet" href="../css/home.css">
<main class="home">
    <section class="home-main-visual">
        <h1>ようこそ、紙たばこ専門ECサイトへ</h1>
        <p>人気の紙たばこを多数取り揃えております。</p>
    </section>

    <section class="home-item-list">
        <h2>商品一覧</h2>
        <div class="home-item-list__items">
            <?php
            $pdo = getDB();

            $stmt = $pdo->query("SELECT * FROM ec_item");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $itemId = htmlspecialchars($row['id']);
                $itemName = htmlspecialchars($row['name']);
                $itemPrice = htmlspecialchars($row['price']);
                $imageFile = htmlspecialchars($row['image_filename']);

                echo '<div class="home-item-list__item">';
                echo '<a href="item.php?id=' . $itemId . '">';
                echo '<img src="../itemimg/' . $imageFile . '" alt="' . $itemName . '" class="home-item-list__item-image">';
                echo '</a>';
                echo '<h3 class="home-item-list__item-title">' . $itemName . '</h3>';
                echo '<p class="home-item-list__item-price">価格：' . $itemPrice . '円</p>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <?php
    if (isset($_SESSION['user'])) {
        include 'recommend.php'; // ログイン時のみ表示
    }
    ?>
</main>

<?php include 'footer.php'; ?>
