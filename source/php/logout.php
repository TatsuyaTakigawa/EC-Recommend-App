<?php
    //セッション開始
    session_start();

    //セッション変数の初期化
    $_SESSION = array();
    //クッキーの削除
    setcookie('PHPSESSID','',time()-6000);
    //セッション破棄
    session_destroy();

    //ホーム画面へリダイレクト
    header("Location:./home.php");
    exit();
?>