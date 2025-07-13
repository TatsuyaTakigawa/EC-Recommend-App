<?php
require_once 'DBManager.php';
$pdo = getDB();

//アップロードするフォルダ
$uploaddir = 'itemimg';
//アップロードするファイル
$uploadfilename = basename($_FILES['file']['name']);
//アップロード先のファイル名
//$uploadpath = '../'.$uploaddir.'/'.$uploadfilename;
$uploadpath = './'.$uploaddir.'/'.$uploadfilename;

$uploadpath2 = $uploaddir.'/'.$uploadfilename;

//アップロード
if(move_uploaded_file($_FILES['file']['tmp_name'],$uploadpath)){
    $stmt = $pdo->prepare("insert into ec_item values(null,?,?,?,?,?,?)");
    $stmt->execute([$_POST['maker'],$_POST["name"], $_POST['description'],$_POST['genre'],$uploadpath2,$_POST['price']]);
    //header("Location:./insertitem.php");
    //exit();
}else{
    echo '失敗しました。';
}
