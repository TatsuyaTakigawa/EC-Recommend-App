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
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<?php
require_once 'menu.php';
?>
<?php
    //DB接続
    require_once 'DBManager.php';
    $pdo = getDB();

    //SQLを作成する
    $sql = "select * from ec_item";
    //SQLを発行する
    $stmt = $pdo->query($sql);

?>

<div id="column" class="column04">
    <h3>商品一覧</h3>
    <ul>
        <?php
        foreach ($stmt as $row){
            echo '<li>';
            //商品を表示
            echo '<a href="./itemdetail.php?id=',$row['id'],'">';
            echo '<img class="item" src="../itemimg/',$row['imgpath'],'" />';
            echo '<p>',$row['name'],'</p>';
            echo '<span>',$row['price'],'円</span>';
            echo '</a>';
            echo '';
            echo '</li>';
        }
        ?>
    </ul>
</div>

</body>
</html>