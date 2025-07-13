<?php
    //セッション開始
    session_start();

    //DB接続
    require_once 'DBManager.php';
    $pdo = getDB();

    //SQLを作成する
    $stmt=$pdo->prepare("select * from ec_user where account = ? and password = ?");
    $stmt->bindValue(1,$_POST['account']);
    $stmt->bindValue(2,$_POST['password']);
    $stmt->execute();

    //Fetchで１件のデータを配列に格納する
    $list = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($list['id'])){
        //ログイン成功
        //セッション変数にユーザー情報を格納
        $_SESSION['user'] = array(
            'id'=>$list['id'],
            'name'=>$list['name'],
            'account'=>$list['account'],
            'postcode'=>$list['postcode'],
            'address'=>$list['address'],
            'phone'=>$list['phone'],
            'mail'=>$list['mail']
        );
        //ホーム画面へリダイレクト
        header("Location:./home.php");
        exit();
    }else{
        //ログイン失敗
        echo 'アカウントまたはパスワードが正しくありません';
        echo '<p><a href="index.php">トップページへ</a></p>';
    }

?>