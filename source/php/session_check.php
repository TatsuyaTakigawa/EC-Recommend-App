<?php
function isLoggedIn() {
    return isset($_SESSION['user']);
}

function getLoginUserId() {
    return $_SESSION['user']['id'] ?? null;
}

function getLoginUserName() {
    return $_SESSION['user']['name'] ?? '';
}
?>
