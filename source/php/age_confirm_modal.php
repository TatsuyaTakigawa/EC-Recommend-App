<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$showAgeModal = !isset($_SESSION['age_confirmed']);
if (!$showAgeModal) {
    return; // 既に確認済みなら何も出さない
}
?>

<link rel="stylesheet" href="../css/age_confirm_modal.css">
<div id="ageModal" class="modal">
  <div class="modal-content">
    <p class="warning">20歳未満の者の喫煙は法律で禁止されています。</p>
    <p class="confirm">私は満20歳以上の喫煙者であることを確認します。</p>
    <div class="btn-group">
      <button id="btnYes">はい（進む）</button>
      <button id="btnNo">いいえ（戻る）</button>
    </div>
  </div>
</div>

<script>
  const modal = document.getElementById('ageModal');
  modal.style.display = 'flex';

  document.getElementById('btnYes').addEventListener('click', () => {
    fetch('age_confirm.php', { method: 'POST' })
      .then(() => {
        modal.style.display = 'none';
        location.reload();
      });
  });

  document.getElementById('btnNo').addEventListener('click', () => {
    alert('申し訳ありませんが、20歳未満の方はご利用いただけません。');
    window.location.href = 'https://www.google.com'; // 必要に応じて変更
  });
</script>
