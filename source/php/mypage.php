<?php
    //セッション開始
    session_start();
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ユーザー管理</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/menu2.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<?php
require_once 'menu.php';
?>

    <h1>ユーザー情報</h1>
    <p>編集する場合は、変更ボタンを押してください。</p>
    <form action="mypage_edit.php" method="post">
        <table>
            <tr><td>名前</td><td><?= $_SESSION['user']['name'] ?></td></tr>
            <tr><td>郵便番号</td><td><?= $_SESSION['user']['postcode'] ?></td></tr>
            <tr><td>住所</td><td><?= $_SESSION['user']['address'] ?></td></tr>
            <tr><td>携帯電話</td><td><?= $_SESSION['user']['phone'] ?></td></tr>
            <tr><td>メールアドレス</td><td><?= $_SESSION['user']['mail'] ?></td></tr>
            <tr><td><button type="submit">変更</button></td></tr>
        </table>
    </form>

    <h1>購入履歴</h1>
<?php
    //DB接続
    require_once 'DBManager.php';
    $pdo = getDB();

    //購入テーブルに挿入する
    $stmt=$pdo->prepare("select 
        ec_purchase.id as cartid,
        ec_purchase.date,
        ec_item.id as itemid,
        ec_item.name,
        ec_item.price,
        ec_item.imgpath
        from ec_purchase
        inner join ec_item on ec_item.id = ec_purchase.itemid 
        where ec_purchase.userid = ?");
    $stmt->bindValue(1,$_SESSION['user']['id']);
    $stmt->execute();
?>
<div>
    <ul>
        <table border="1">
            <?php
            foreach ($stmt as $row){
                echo '<tr>';
                echo '<td>',$row['date'],'</td>';
                echo '<td><img class="item" src="../itemimg/',$row['imgpath'],'" /></td>';
                echo '<td>',$row['name'],'<br>',$row['price'],'円</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </ul>
</div>
</body>
</html>
