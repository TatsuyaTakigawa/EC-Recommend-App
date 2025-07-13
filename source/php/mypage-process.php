<?php
//セッション開始
session_start();

//DB接続
require_once 'DBManager.php';
$pdo = getDB();
//テーブルを更新
$stmt=$pdo->prepare("update ec_user set name=?,postcode=?,address=?,phone=?,mail=? where id = ?");
$stmt->bindValue(1,$_POST['name']);
$stmt->bindValue(2,$_POST['postcode']);
$stmt->bindValue(3,$_POST['address']);
$stmt->bindValue(4,$_POST['phone']);
$stmt->bindValue(5,$_POST['mail']);
$stmt->bindValue(6,$_SESSION['user']['id']);
$stmt->execute();
//セッション変数へ格納
$_SESSION['user']['name'] = $_POST['name'];
$_SESSION['user']['postcode'] = $_POST['postcode'];
$_SESSION['user']['address'] = $_POST['address'];
$_SESSION['user']['phone'] = $_POST['phone'];
$_SESSION['user']['mail'] = $_POST['mail'];

//ホーム画面へリダイレクト
header("Location:./mypage.php");
exit();
?>