<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>紙たばこECサイト</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/common.css">
</head>

<body class="<?= htmlspecialchars($page_class ?? '') ?>">
    <div class="header-wrapper">
        <?php include 'menu.php'; ?>
        <?php include 'age_confirm_modal.php'; ?>

