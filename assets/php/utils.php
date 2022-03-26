<?php
    function getPlayernameByUUID(String $uuid) {
        require(dirname(__FILE__, 3)."/assets/php/mysql.php");
        $stmt = $mysql->prepare("SELECT m_name FROM players WHERE uuid = :uuid");
        $stmt->bindParam(":uuid", $uuid);

        $stmt->execute();

        if($stmt->rowCount() == 1) {

            $row = $stmt->fetch();
            return $row["m_name"];
        }
    }
?>