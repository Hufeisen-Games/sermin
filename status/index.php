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
                    if(!isset($_GET["id"])) {
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
                    } else {
                        $stmt = $mysql->prepare("SELECT * FROM `status` WHERE id = :id");
                        $id = str_replace("'", "-", $_GET["id"]);
                        $stmt->bindParam(":id", $_GET["id"]);
                        $stmt->execute();
    
                        $row = $stmt->fetch();

                        $public = "";
                        $maintenance = "";

                        if($row['status'] == "maintenance") {
                            $maintenance = "checked";
                        }
                        if($row['public'] == "1") {
                            $public = "checked";
                        }

                        echo "
                            <div class='status-edit'>
                                <div class='top'>
                                <span class='material-icons-sharp'>keyboard_backspace</span>
                                    <h3>$row[display_name]</h3>
                                </div>
                                <form>
                                    <div class='form-group'>
                                        <label for='display_name'>Display Name</label>
                                        <input value='$row[display_name]' id='display_name' name='display_name' type='text' placeholder='server' required>
                                    </div>
                                    <div class='form-group'>
                                        <label for='ip'>IP Adress</label>
                                        <input value='$row[ip]' id='ip' name='ip' type='text' placeholder='127.0.0.1' required>
                                    </div>
                                    <div class='form-group'>
                                        <label for='port'>Port</label>
                                        <input value='$row[port]' id='port' name='port' type='number' placeholder='25565' required>
                                    </div>
                                    <div class='checkboxes'>
                                        <div title='Is the page available on the public status page?'>
                                            <label for='ispublic'>Public
                                                <input id='ispublic' name='ispublic' type='checkbox' $public>
                                                <span class='checkmark'></span>
                                            </label>
                                        </div>
                                        <div title='Is the server in maintenance on the status page?'>
                                            <label for='ismaintenance'>Maintenance
                                                <input id='ismaintenance' name='isinmaintenance' type='checkbox' $maintenance>
                                                <span class='checkmark'></span>
                                            </label>
                                        </div>
                                    </div>
                                    <input class='submit' type='submit'>
                                </form>
                            </div>
                            ";
                    }
                ?>
            </main>
            <!--------------- END OF MAIN -------------->
        </div>

        <script src="./assets/js/index.js"></script>
        <script>
            document.querySelector('aside .sidebar .status').classList.toggle('active');
        </script>
    </body>
</html>