<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beta Playerstats page</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>
    <?php
    require_once('func.php');
    require_once('settings.php');

    //echo "<script type='text/javascript' src='file.js'></script>";
    //get json data from url
    $players = file_get_contents( $address . '/v1/players');
    $server_stats = file_get_contents( $address . '/v1/server');
    $server = json_decode($server_stats);
    $world_stats = file_get_contents( $address . '/v1/worlds/'.  $overworld);
    $world_stats = json_decode($world_stats);

    /* #region server-stats */
    //SERVER STATS
    $server = json_decode($server_stats);
    echo "The server TPS is " . $server->tps . "<br>";

    //prints uptime
    $seconds = $server->health->uptime;
    echo "The server Uptime is " . secondsToTime($seconds) . "<br>";

    //check to see if it is storming . if it is also check to see if it is thundering else its clear
    //world_stats>storm true or false
    //world_stats>thundering true or false
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