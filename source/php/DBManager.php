<?php
function getDB(){
    try {
        $pdo = new PDO(
            'mysql:host=tutorial-db-instance.czkelgm3rry3.us-east-1.rds.amazonaws.com;dbname=sample;charset=utf8',
            'tutorial_user',
            'tutorial_user',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        // エラー内容を表示（デバッグ用）
        echo "❌ データベース接続失敗: " . $e->getMessage();
        exit; // エラー時は終了
    }
}
?>
