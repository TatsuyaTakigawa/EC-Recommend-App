<?php
include 'header.php';
require_once 'DBManager.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$pdo = getDB();
$user = $_SESSION['user'];

$success = '';
$error = '';

// 更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $mail = $_POST['mail'] ?? '';

    if ($name && $postcode && $address && $phone && $mail) {
        $stmt = $pdo->prepare("UPDATE ec_user SET name = ?, postcode = ?, address = ?, phone = ?, mail = ? WHERE id = ?");
        $stmt->execute([$name, $postcode, $address, $phone, $mail, $user['id']]);

        // セッション情報を更新
        $_SESSION['user']['name'] = $name;
        $success = '情報を更新しました。';
    } else {
        $error = 'すべての項目を入力してください。';
    }
}

// 最新情報の取得
$stmt = $pdo->prepare("SELECT * FROM ec_user WHERE id = ?");
$stmt->execute([$user['id']]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="../css/form.css"> <!-- form.css を読み込む -->
<main class="form-main"> <!-- ← form.css に合わせて -->

    <?php if ($success): ?>
        <p class="form-success"><?= htmlspecialchars($success) ?></p>
    <?php elseif ($error): ?>
        <p class="form-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="edit_user.php" method="post">
        <h2>会員情報の編集</h2>

        <label for="name">お名前：</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>

        <label for="postcode">郵便番号：</label>
        <input type="text" id="postcode" name="postcode" value="<?= htmlspecialchars($userData['postcode']) ?>" required>

        <label for="address">住所：</label>
        <input type="text" id="address" name="address" value="<?= htmlspecialchars($userData['address']) ?>" required>

        <label for="phone">電話番号：</label>
        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($userData['phone']) ?>" required>

        <label for="mail">メールアドレス：</label>
        <input type="email" id="mail" name="mail" value="<?= htmlspecialchars($userData['mail']) ?>" required>

        <button type="submit">更新</button>
    </form>
</main>

<?php include 'footer.php'; ?>
