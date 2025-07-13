<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ユーザー管理</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h1>ログイン</h1>

<form action="login-output.php" method="post">
    <p>アカウントとパスワードを入力してください。</p>
    <p>アカウント：<input type="text" name="account" required="required"></p>
    <p>パスワード：<input type="password" name="password" required="required"></p>
    <p><button type="submit" name="action" value="send">ログイン</button></p>
</form>

</body>
</html>
