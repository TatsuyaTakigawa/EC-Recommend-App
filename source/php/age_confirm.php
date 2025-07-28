<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['age_confirmed'] = true;
http_response_code(200);
