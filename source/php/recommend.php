<?php
require_once 'recommend_functions.php';

$userId = $_SESSION['user']['id'];
$name = $_SESSION['user']['name'];
$recommendedItems = getRecommendedProducts((string)$userId, 6);

if (empty($recommendedItems)) {
    echo '<section class="item-list"><h2>おすすめ商品</h2><p>おすすめ商品はありません。</p></section>';
    return;
}
?>

<section class="home-item-list">
    <h2><?php echo $name; ?>さんのおすすめ商品</h2>
    <div class="home-item-list__items">
        <?php
        foreach ($recommendedItems as $item) {
            $itemId = htmlspecialchars($item['id']);
            $itemName = htmlspecialchars($item['name']);
            $itemPrice = htmlspecialchars($item['price']);
            $imageFile = htmlspecialchars($item['image_filename']);

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
