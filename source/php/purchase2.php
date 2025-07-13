<?php
    //セッション開始
    session_start();

    //DB接続
    require_once 'DBManager.php';
    $pdo = getDB();

    //購入テーブルに挿入する
    $stmt=$pdo->prepare("insert into ec_purchase select null,?,itemid,? from ec_cart where userid=?");
    $stmt->bindValue(1,$_SESSION['user']['id']);
    $stmt->bindValue(2,date('Y/m/d'));
    $stmt->bindValue(3,$_SESSION['user']['id']);
    $stmt->execute();

    //カートテーブルから削除する
//    $stmt2=$pdo->prepare("delete from ec_cart where id = ?");
//    $stmt2->bindValue(1,$_POST['cartid']);
//    $stmt2->execute();
    $stmt2=$pdo->prepare("delete from ec_cart where userid = ?");
    $stmt2->bindValue(1,$_SESSION['user']['id']);
    $stmt2->execute();

    //ホーム画面へリダイレクト
    header("Location:./cart.php");
    exit();

?>