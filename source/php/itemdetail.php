<?php
    require_once 'common_login.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aso商店</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/menu2.css">
    <link rel="stylesheet" href="../css/itemdetail.css">
</head>
<body>
<?php
require_once 'menu.php';
?>

<p>ここは商品詳細画面です</p>

<?php
    //DB接続
    require_once 'DBManager.php';
    $pdo = getDB();

    //SQLを作成する
    $stmt=$pdo->prepare("select * from ec_item where id = ?");
    $stmt->bindValue(1,$_GET['id']);
    $stmt->execute();

    //Fetchで１件のデータを配列に格納する
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
?>

    <h1><?= $item['name'] ?></h1>
    <table>
        <tr>
            <td><img class="item" src="../itemimg/<?= $item['imgpath'] ?>"></td>
            <td>
                <div><?= $item['description'] ?></div>
                <div>定価：<?= $item['price'] ?>円</div>
            </td>
        </tr>
    </table>
    <p><a href="cart.php?cartid=<?= $_GET['id'] ?>">カートに入れる</a></p>
    <p><a href="home.php">商品一覧に戻る</a></p>
</body>
</html>