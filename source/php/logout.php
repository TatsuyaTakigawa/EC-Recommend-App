<?php
include 'header.php';
?>

<link rel="stylesheet" href="../css/logout.css">
<main class="logout-main">
  <h2 class="logout-title">ログアウト確認</h2>
  <p class="logout-message">ログアウトしますか？</p>

  <form class="logout-form" action="logout_exec.php" method="post">
    <button type="submit" name="confirm" value="yes" class="btn btn-confirm">はい</button>
    <button type="button" onclick="window.location.href='home.php'" class="btn btn-cancel">いいえ</button>
  </form>
</main>

<?php include 'footer.php'; ?>
