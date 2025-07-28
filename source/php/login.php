<?php
$page_class = 'login';
include 'header.php';

// リダイレクト先を取得（指定がなければ home.php）
$redirect = $_GET['redirect'] ?? ($_SERVER['HTTP_REFERER'] ?? 'home.php');

// エラーメッセージの取得
$error = $_GET['error'] ?? '';
?>

<link rel="stylesheet" href="../css/form.css">
<body class="login">
<main class="login-main">
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="login_process.php" method="post" class="login-form">
        <h2>ログイン</h2>

        <label for="account">アカウント名またはメールアドレス：</label>
        <input type="text" name="account" id="account" required>

        <label for="password">パスワード：</label>
        <input type="password" name="password" id="password" required>

        <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">

        <button type="submit">ログイン</button>

        <p class="notice">会員登録がお済みでない方は <a href="register.php">こちら</a> から登録してください。</p>
    </form>
</main>
</body>

<?php include 'footer.php'; ?>
