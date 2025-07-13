<?php
    //セッション開始
    session_start();

    //DB接続
    require_once 'DBManager.php';
    $pdo = getDB();

    //購入テーブルに挿入する
    $stmt=$pdo->prepare("insert into ec_purchase values(null,?,?,?)");
    $stmt->bindValue(1,$_SESSION['user']['id']);
    $stmt->bindValue(2,$_POST['itemid']);
    $stmt->bindValue(3,date('Y/m/d'));
    $stmt->execute();

    //カートテーブルから削除する
    $stmt2=$pdo->prepare("delete from ec_cart where id = ?");
    $stmt2->bindValue(1,$_POST['cartid']);
    $stmt2->execute();

    //ホーム画面へリダイレクト
    header("Location:./cart.php");
    exit();

?>