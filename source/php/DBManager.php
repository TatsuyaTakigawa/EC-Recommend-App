<?php
    function getDB(){
        $pdo = new PDO(
            'mysql:host=localhost;dbname=tobacco_ecsite;charset=utf8',
            'root',
            ''
        );
        return $pdo;
    }
?>
