<?php
    function getDB(){
        $pdo = new PDO(
            'mysql:host=localhost;dbname=ec-recommend-app;charset=utf8',
            'root',
            ''
        );
        return $pdo;
    }
?>
