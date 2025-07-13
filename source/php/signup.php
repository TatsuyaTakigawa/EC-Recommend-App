<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>ユーザー管理</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<form action="signup-output.php" method="post">
    <h1>ユーザー情報登録</h1>

    <p>ユーザー情報を登録してください。</p>
    <table>
        <tr><td>名前</td><td><input type="text" name="name" required="required"></td></tr>
        <tr><td>アカウント</td><td><input type="text" name="account" required="required"></td></tr>
        <tr><td>パスワード</td><td><input type="password" name="password" required="required"></td></tr>
        <tr><td>郵便番号</td><td><input type="text" name="postcode"></td></tr>
        <tr><td>住所</td><td><input type="text" name="address"></td></tr>
        <tr><td>携帯電話</td><td><input type="text" name="phone"></td></tr>
        <tr><td>メールアドレス</td><td><input type="text" name="mail"></td></tr>
        <tr><td><button type="submit" name="action" value="send">登録</button></td><td></td></tr>
    </table>
</form>

</body>
</html>
