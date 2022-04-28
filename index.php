<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beta Playerstats page</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <!---<script type='text/javascript' src='file.js'></script>--->
</head>

<body>
    <?php
    require_once('func.php');
    require_once('settings.php');

    /* #region server-stats */
    //SERVER STATS

    //Convert server ticks to 24 hour time. 0 ticks being 6am and 5:59:59am is 24000 ticks.
    $server_ticks = $world_stats->time;

    echo "The server TPS is " . $server->tps . "<br>";

    //prints uptime
    $seconds = $server->health->uptime;
    echo "The server uptime is " . secondsToTime($seconds) . "<br>";

    //check to see if it is storming . if it is also check to see if it is thundering else its clear
    if ($world_stats->storm == true) {
        if ($world_stats->thundering == true) {
            echo "The server weather thundering<br>";
        } else {
            echo "The server weather is storming<br>";
        }
    } else {
        echo "The server weather is clear<br>";
    }
    
    /* #endregion */
    //PLAYER STATS
    //check how many players are online and print the number
    $online = 0;
    foreach (json_decode($players) as $player) {
        $online++;
    }

    //if player count is 1, then print "1 player is online" else print "X players are online"
    if ($online == 1) {
        echo "<h1>There is 1 player is online</h1>";
    } else {
        echo "<h1>There are " . $online . " players are online</h1>";
    }
    foreach (json_decode($players) as $player) {

        //gets stats about the player
        echo "<div class='player'>";
        echo "<h2>" . $player->displayName . "</h2>";
        echo "<a href='player.php?uuid=" . $player->uuid . "'>View Player</a>";
        echo "<br>";

        //get the players head
        echo "<img src='https://crafatar.com/avatars/" . $player->uuid . "' width=64px alt='Minecraft player head'/>" . '<br> <br>';
        echo "</div>";
    }
    ?>
</body>

</html>
