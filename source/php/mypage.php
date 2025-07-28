<?php
include 'header.php';
require_once 'DBManager.php';

// ログインしていない場合はログインページへリダイレクト
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];

// 最新のユーザー情報をDBから取得（セッション情報が古い可能性があるため）
$pdo = getDB();
$stmt = $pdo->prepare('SELECT * FROM ec_user WHERE id = ?');
$stmt->execute([$user['id']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../css/mypage.css">
<main class="mypage-main">
    <h2 class="mypage-title">マイページ</h2>

    <section class="mypage-user-info">
        <table class="mypage-table">
            <tbody>
                <tr>
                    <th>お名前</th>
                    <td><?= htmlspecialchars($userData['name']) ?></td>
                </tr>
                <tr>
                    <th>アカウント名</th>
                    <td><?= htmlspecialchars($userData['account']) ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?= htmlspecialchars($userData['mail']) ?></td>
                </tr>
                <tr>
                    <th>郵便番号</th>
                    <td><?= htmlspecialchars($userData['postcode']) ?></td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td><?= htmlspecialchars($userData['address']) ?></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><?= htmlspecialchars($userData['phone']) ?></td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="mypage-actions">
        <a href="edit_user.php" class="mypage-btn">会員情報を編集</a>
        <a href="purchase_history.php" class="mypage-btn">購入履歴を見る</a>
    </section>
</main>


<?php include 'footer.php'; ?>
