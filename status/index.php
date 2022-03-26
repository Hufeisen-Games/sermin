<?php
    $path = dirname(__FILE__, 2);
    require("$path/assets/php/start.php");
    require("$path/assets/php/MinecraftPing.php");
    require("$path/assets/php/MinecraftPingException.php");

    use xPaw\MinecraftPing;
	use xPaw\MinecraftPingException;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SERMIN - Admin Dashboard</title>
        <!-- MATERIAL CDN -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
        <!-- STYLESHEET -->
        <link rel="stylesheet" href="./assets/css/style.css">
    </head>
    <body>
        <div class="container">
            <?php require("$path/assets/moduls/aside.php");?>
            <!--------------- END OF SIDEBAR -------------->

            <main>
                <div class="header">
                    <div class="left">
                        <h1>Status</h1>
                    </div>
                    <div class="right">
                        <div class="theme-toggler">
                            <span class="material-icons-sharp active">light_mode</span>
                            <span class="material-icons-sharp">dark_mode</span>
                        </div>
                        <?php require("$path/assets/moduls/profile.php")?>
                    </div>
                </div>
                <?php
                    if(isset($_GET["id"])) {
                        echo '<div class="status">';
                        $stmt = $mysql->query("SELECT * FROM `status` ORDER BY `order_id` ASC");
                        $stmt->execute();
                        $count = $stmt->rowCount();

                        for($i=0; $i < $count; $i++) {
                            $row = $stmt->fetch();

                            try
                            {
                                $Query = new MinecraftPing($row["ip"], $row["port"]);
                                
                                $playerInfo = $Query->Query()["players"];
                                $maxPlayers = $playerInfo["max"];
                                $onlinePlayers = $playerInfo["online"];

                                if($row["status"] == "online") {
                                    echo "
                                        <div class='$row[id]'>
                                            <div class='left'>
                                                <h1>$row[display_name]</h1>
                                            </div>
                                            <div class='right'>
                                                <div class='top'>
                                                    <h2 class='online'>Online</h2>
                                                    <img src='./assets/img/online.png'>
                                                </div>
                                                <div class='bottom'>
                                                <h3>$onlinePlayers/$maxPlayers Players</h3>
                                                </div>
                                            </div>
                                            <div class='edit'>
                                                <h3>Edit</h3>
                                            </div>
                                        </div>
                                        ";
                                } else {
                                    echo "
                                    <div class='$row[id]'>
                                        <div class='left'>
                                            <h1>$row[display_name]</h1>
                                        </div>
                                        <div class='right'>
                                            <div class='top'>
                                                <h2 class='maintenance'>Maintenance</h2>
                                                <img src='./assets/img/maintenance.png'>
                                            </div>
                                            <div class='bottom'>
                                            <h3>0/$maxPlayers Players</h3>
                                            </div>
                                        </div>
                                        <div class='edit'>
                                            <h3>Edit</h3>
                                        </div>
                                    </div>
                                    ";
                                }
                            }
                            catch( MinecraftPingException $e )
                            {
                                echo "
                                <div class='$row[id]'>
                                    <div class='left'>
                                        <h1>$row[display_name]</h1>
                                    </div>
                                    <div class='right'>
                                        <div class='top'>
                                            <h2 class='offline'>Offline</h2>
                                            <img src='./assets/img/offline.png'>
                                        </div>
                                        <div class='bottom'>
                                        <h3>0/0 Players</h3>
                                        </div>
                                    </div>
                                    <div class='edit'>
                                        <h3>Edit</h3>
                                    </div>
                                </div>
                                ";
                            }
                        }
                        echo "</div>";
                    }
                ?>
                <div class="status-edit">
                    <h3>Lobby</h3>
                    <form>
                        <input type="">
                    </form>
                </div>
            </main>
            <!--------------- END OF MAIN -------------->
        </div>

        <script src="./assets/js/index.js"></script>
        <script>
            document.querySelector('aside .sidebar .status').classList.toggle('active');
        </script>
    </body>
</html>