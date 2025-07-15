<?php
    // ===== 必要なファイルを読み込む =====
    require_once 'DBManager.php';           // データベース接続用
    require_once 'get_recommendations.php'; // 今作成した関数を読み込む

    // セッションを開始してユーザーIDを取得
    // session_start();
    $userId = $_SESSION['user_id'] ?? '1'; // ログインしていなければデバッグ用に '1' を使う

    // ===== 関数を呼び出して、おすすめ商品IDを取得 =====
    $recommendedIds = fetchRecommendationIds($userId);

    // 結果を格納する変数を初期化
    $products = [];

    // ===== 取得したIDを使ってデータベースから商品情報を取得 =====
    // recommendedIdsが空でなければ処理を実行
    if (!empty($recommendedIds)) {
        $pdo = getDB();

        // IN句のプレースホルダ (?,?,?...) を動的に生成
        $placeholders = implode(',', array_fill(0, count($recommendedIds), '?'));

        $sql = "SELECT id, name AS product_name, price, imgpath AS image_path FROM ec_item WHERE id IN ($placeholders)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($recommendedIds);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>あなたへのおすすめ</title>
        <style>
            /* CSSで表示スタイルを定義 (変更なし) */
            body {
                font-family: sans-serif;
            }
            .recommend-title {
                text-align: center;
                margin: 20px 0;
            }
            .recommend-container {
                display: flex;
                flex-wrap: wrap; /* 画面サイズに応じて折り返す */
                justify-content: center; /* 中央揃え */
                gap: 20px; /* カード間の隙間 */
                padding: 10px;
            }
            .product-card {
                width: 220px;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden; /* 角丸の外にはみ出さないように */
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                text-decoration: none; /* リンクの下線を消す */
                color: inherit; /* 親要素の色を継承 */
                transition: transform 0.2s;
            }
            .product-card:hover {
                transform: translateY(-5px); /* ホバー時に少し浮き上がる */
            }
            .product-card img {
                width: 100%;
                height: 200px; /* 高さを固定 */
                object-fit: cover; /* アスペクト比を保ったままトリミング */
                display: block;
            }
            .product-info {
                padding: 15px;
            }
            .product-name {
                font-size: 16px;
                font-weight: bold;
                margin: 0 0 10px 0;
                /* 2行までに制限して、はみ出た部分は...で表示 */
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                height: 2.4em; /* (font-size * line-height) * 2行 */
                line-height: 1.2em;
            }
            .product-price {
                font-size: 18px;
                color: #d9534f; /* 価格の色を赤系に */
                margin: 0;
                text-align: right;
            }
        </style>
    </head>
    <body>

        <h2 class="recommend-title">あなたへのおすすめ商品</h2>

        <div class="recommend-container">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <!-- 商品カードの始まり -->
                    <!-- ======================= ▼▼▼ 変更点 2 ▼▼▼ ======================= -->
                    <!-- リンク先をサンプルコードに合わせて ./itemdetail.php に修正 -->
                    <a href="./itemdetail.php?id=<?= htmlspecialchars($product['id'], ENT_QUOTES, 'UTF-8') ?>" class="product-card">
                    <!-- ======================= ▲▲▲ 変更点 2 ▲▲▲ ======================= -->

                        <!-- ======================= ▼▼▼ 変更点 3 ▼▼▼ ======================= -->
                        <!-- 画像パスの前に ../itemimg/ を追加 -->
                        <img src="../itemimg/<?= htmlspecialchars($product['image_path'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8') ?>">
                        <!-- ======================= ▲▲▲ 変更点 3 ▲▲▲ ======================= -->

                        <div class="product-info">
                            <!-- SQLで別名を付けたため、ここの変数は変更不要 -->
                            <p class="product-name"><?= htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8') ?></p>
                            <!-- priceは元々同じ名前なので変更不要 -->
                            <p class="product-price">¥<?= htmlspecialchars(number_format($product['price']), ENT_QUOTES, 'UTF-8') ?>円</p>
                        </div>
                    </a>
                    <!-- 商品カードの終わり -->
                <?php endforeach; ?>
            <?php else: ?>
                <p>おすすめ商品が見つかりませんでした。</p>
            <?php endif; ?>
        </div>

    </body>
</html>