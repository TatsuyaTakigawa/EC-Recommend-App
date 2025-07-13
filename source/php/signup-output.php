<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ユーザー管理</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h1>ユーザー情報登録</h1>

<?php
        //DB接続
        require 'DBManager.php';
        $pdo = getDB();

        //SQLを作成
        $stmt = $pdo->prepare("insert into ec_user values(null,?,?,?,?,?,?,?)");

        //SQLを発行
        $stmt->bindValue(1,$_POST['name']);
        $stmt->bindValue(2,$_POST['account']);
        $stmt->bindValue(3,$_POST['password']);
        $stmt->bindValue(4,$_POST['postcode']);
        $stmt->bindValue(5,$_POST['address']);
        $stmt->bindValue(6,$_POST['phone']);
        $stmt->bindValue(7,$_POST['mail']);
        $stmt->execute();
        echo 'ユーザー登録が完了しました';

?>
<br>
<p><a href="./index.php">トップ画面へ</a></p>
<p><a href="./login.php">ログイン画面へ</a></p>

</body>
</html>
