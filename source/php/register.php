<?php
$page_class = 'register';
include 'header.php';


// エラーと入力値（old）をGETパラメータから取得
$error = $_GET['error'] ?? '';
$redirect = $_GET['redirect'] ?? 'home.php';
$old = [];

if (isset($_GET['old'])) {
    $oldJson = urldecode($_GET['old']);
    $decoded = json_decode($oldJson, true);
    if (is_array($decoded)) {
        $old = $decoded;
    }
}
?>

<link rel="stylesheet" href="../css/form.css">
<body class="register">
<main class="register-main">
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" action="register_process.php" class="register-form">
        <h2>会員登録</h2>

        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">

        <label for="name">氏名</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>

        <label for="account">アカウント名</label>
        <input type="text" name="account" id="account" value="<?= htmlspecialchars($old['account'] ?? '') ?>" required>

        <label for="password">パスワード</label>
        <input type="password" name="password" id="password" required>

        <label for="postcode">郵便番号</label>
        <input type="text" name="postcode" id="postcode" value="<?= htmlspecialchars($old['postcode'] ?? '') ?>">

        <label for="address">住所</label>
        <input type="text" name="address" id="address" value="<?= htmlspecialchars($old['address'] ?? '') ?>">

        <label for="phone">電話番号</label>
        <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">

        <label for="mail">メールアドレス</label>
        <input type="email" name="mail" id="mail" value="<?= htmlspecialchars($old['mail'] ?? '') ?>" required>

        <button type="submit">登録する</button>

        <p class="notice">すでに会員登録がお済みの方は <a href="login.php">こちら</a> からログインしてください。</p>
    </form>
</main>
</body>

<?php include 'footer.php'; ?>
