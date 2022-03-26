<?php
    session_start();
    $_SESSION["uuid"] = "testUUID";

    if(!isset($_SESSION["uuid"])) {
        header("Location: /login");
    }

    require(dirname(__FILE__, 3)."/assets/php/mysql.php");
    require(dirname(__FILE__, 3)."/assets/php/utils.php");

    $stmt = $mysql->prepare("SELECT * FROM logs WHERE TIMESTAMPDIFF(HOUR, time, CURRENT_TIMESTAMP()) <= 24 AND type = 'playerJoin'");
    $stmt->execute();
    $SITE_VARS["online_players"] = $stmt->rowCount();

    $stmt = $mysql->prepare("SELECT * FROM logs WHERE TIMESTAMPDIFF(HOUR, time, CURRENT_TIMESTAMP()) <= 24 AND type = 'newPlayer'");
    $stmt->execute();
    $SITE_VARS["new_players"] = $stmt->rowCount();

    $stmt = $mysql->prepare("SELECT * FROM logs WHERE TIMESTAMPDIFF(HOUR, time, CURRENT_TIMESTAMP()) <= 24 AND type = 'playerBanned'");
    $stmt->execute();
    $SITE_VARS["banned_players"] = $stmt->rowCount();

    $SITE_VARS["username"] = getPlayernameByUUID($_SESSION["uuid"]);
?>