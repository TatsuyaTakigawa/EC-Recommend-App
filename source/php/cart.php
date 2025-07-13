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
//require_once 'menu_old.php';
require_once 'menu.php';
?>
<?php
    //DB接続
    require_once 'DBManager.php';
    $pdo = getDB();

    //カートに追加
    if(isset($_GET['cartid'])){
        $stmt1=$pdo->prepare("insert into ec_cart values(null,?,?)");
        $stmt1->bindValue(1,$_SESSION['user']['id']);
        $stmt1->bindValue(2,$_GET['cartid']);
        $stmt1->execute();
    }

    //カートの一覧を表示
    $stmt=$pdo->prepare("select 
                ec_cart.id as cartid,
                ec_item.id as itemid,
                ec_item.name,
                ec_item.price,
                ec_item.imgpath
                from ec_cart 
                inner join ec_item on ec_item.id=ec_cart.itemid 
                where userid=?");
    $stmt->bindValue(1,$_SESSION['user']['id']);
    $stmt->execute();

    //カートの一覧を表示
/*
    $stmt=$pdo->prepare("select 
                ec_cart.id as cartid,
                ec_item.id as itemid,
                ec_item.name,
                ec_item.price,
                ec_item.imgpath
                from ec_cart,ec_item
                where ec_item.id=ec_cart.itemid 
                and userid=?");
    $stmt->bindValue(1,$_SESSION['user']['id']);
    $stmt->execute();
*/
?>

<div>
    <h1>カート商品一覧</h1>
    <ul>
        <table border="1">
        <?php
        foreach ($stmt as $row){
            echo '<tr>';
            echo '<td><img class="item" src="../itemimg/',$row['imgpath'],'" /></td>';
            echo '<td>',$row['name'],'<br>',$row['price'],'円</td>';
            echo '<td>';
            echo '<form action="purchase.php" method="post">';
            echo '<input type="hidden" name="cartid" value="',$row['cartid'],'">';
            echo '<input type="hidden" name="itemid" value="',$row['itemid'],'">';
            echo '<input type="submit" value="購入する" />';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
        </table>
    </ul>
</div>

<div>
    <form action="purchase2.php" method="post">
    <input type="submit" value="全部購入する" />
    </form>
</div>

</body>
</html>