<nav class="menu-navbar">
    <div class="menu-logo">
        <a href="home.php">Tobacco Store</a>
    </div>

    <div class="menu-hamburger" id="hamburger">
        <span class="menu-hamburger__line"></span>
        <span class="menu-hamburger__line"></span>
        <span class="menu-hamburger__line"></span>
    </div>

    <ul class="menu-nav-links" id="nav-links">
        <li><a href="home.php">ホーム</a></li>
        <li><a href="cart.php">カート</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <li><a href="logout.php">ログアウト</a></li>
            <li><a href="mypage.php">マイページ</a></li>
        <?php else: ?>
            <li><a href="login.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>">ログイン</a></li>
            <li><a href="register.php?redirect=<?= urlencode($_SERVER['REQUEST_URI']) ?>">会員登録</a></li>
        <?php endif; ?>
    </ul>
</nav>

<script>
document.getElementById('hamburger').addEventListener('click', function() {
    document.getElementById('nav-links').classList.toggle('menu-nav-links--active');
});

// メニュー内のリンクをクリックしたら閉じる
document.querySelectorAll('#nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        document.getElementById('nav-links').classList.remove('menu-nav-links--active');
    });
});
</script>

