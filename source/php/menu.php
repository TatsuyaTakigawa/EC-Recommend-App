<?php

//DB接続
require_once 'DBManager.php';
$pdo = getDB();

//SQLを作成する
$sql = "select * from ec_genre";
//SQLを発行する
$stmt = $pdo->query($sql);

?>
<div class="container">
    <div class="item1"><p><a class="menu" href="./home.php">Aso商店</a></p></div>
    <div class="item2"><p>ようこそ　<?= $_SESSION['user']['name'] ?>さん</p></div>
</div>
<div class="container">
    <div class="item1">
        <form method="post" action="./home.php">
            商品検索
            <!-- 検索キーワード -->
            <input type="text" name="searchWord">
            <!-- ジャンルのリストボックス -->
            <select name="searchGenre">
                <option value="0"></option>
                <?php
                    foreach ($stmt as $row){
                        echo '<option value="',$row['id'],'">',$row['name'],'</option>';
                    }
                ?>
            </select>
            <input type="submit" value="検索">
        </form>
    </div>
    <div class="item2">
        <a class="menu" href="./mypage.php">マイページ</a>
    </div>
    <div class="item3"><a class="menu" href="./cart.php">カート</a></div>
    <div class="item4"><a class="menu" href="./logout.php">ログアウト</a></div>
</div>
