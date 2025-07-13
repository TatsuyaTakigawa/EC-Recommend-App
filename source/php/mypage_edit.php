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
</head>
<body>
<?php
require_once 'menu.php';
?>

    <h1>ユーザー情報登録</h1>

    <p>保存ボタンで更新する</p>
    <form action="./mypage-process.php" method="post">
    <table> <tr><td>名前</td><td><input type="text" name="name" value="<?=$_SESSION['user']['name']?>" /></td></tr>
        <tr><td>郵便番号</td><td><input type="text" name="postcode" value="<?=$_SESSION['user']['postcode']?>" /></td></tr>
        <tr><td>住所</td><td><input type="text" name="address" value="<?=$_SESSION['user']['address']?>" /></td></tr>
        <tr><td>携帯電話</td><td><input type="text" name="phone" value="<?=$_SESSION['user']['phone']?>" /></td></tr>
        <tr><td>メールアドレス</td><td><input type="text" name="mail" value="<?=$_SESSION['user']['mail']?>" /></td></tr>
        <tr><td><input type="submit" value="保存" /></td></tr>
   </table>
   </form>

</body>
</html>
