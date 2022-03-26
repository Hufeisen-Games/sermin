<?php
    $servername = "db.hufeisen-games.de:3306";
    $username = "sermin_test";
    $password = "Sermin_test_1";
    $dbname = "sermin_test";
    try{
        $mysql = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        echo "SQL Error: ".$e->getMessage();
    }
?>