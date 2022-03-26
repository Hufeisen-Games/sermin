<?php
    $path = dirname(__FILE__, 1);
    require("$path/assets/php/start.php");
?>
<!DOCTYPE html>
<!-- 
    Modules Used: xPaw PHP-Minecraft-Query
-->
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
                        <h1>Dashboard</h1>
                    </div>
                    <div class="right">
                        <div class="theme-toggler">
                            <span class="material-icons-sharp active">light_mode</span>
                            <span class="material-icons-sharp">dark_mode</span>
                        </div>
                        <?php require("$path/assets/moduls/profile.php")?>
                    </div>
                </div>

                <div class="insights">
                    <div class="online_players">
                        <div class="middle">
                            <span class="material-icons-sharp">person</span>
                            <div class="right">
                                <h3>Online Players</h3>
                                <h1><?php echo$SITE_VARS["online_players"]?></h1>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>

                    <div class="new_players">
                        <div class="middle">
                            <span class="material-icons-sharp">person_add</span>
                            <div class="right">
                                <h3>New Players</h3>
                                <h1><?php echo$SITE_VARS["new_players"]?></h1>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>

                    <div class="banned_players">
                        <div class="middle">
                            <span class="material-icons-sharp">person_off</span>
                            <div class="right">
                                <h3>Banned Players</h3>
                                <h1><?php echo$SITE_VARS["banned_players"]?></h1>
                            </div>
                        </div>
                        <small class="text-muted">Last 24 Hours</small>
                    </div>
                </div>
                <!--------------- END OF INSIGHTS -------------->

                <div class="recent-activity">
                    <h2>Recent Activity</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $stmt = $mysql->query("SELECT * FROM `logs` WHERE `type` = 'webLog' ORDER BY `id` DESC LIMIT 10");
                                $stmt->execute();
                                $count = $stmt->rowCount();

                                for($i=0; $i < $count; $i++) {
                                    $row = $stmt->fetch();

                                    echo "<tr>
                                            <td>".getPlayernameByUUID($row["uuid"])."</td>
                                            <td>$row[content]</td>
                                          </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                    <a href="#">Show Logs</a>
                </div>
            </main>
            <!--------------- END OF MAIN -------------->
        </div>

        <script src="./assets/js/index.js"></script>
        <script>
            document.querySelector('aside .sidebar .dashboard').classList.toggle('active');
        </script>
    </body>
</html>