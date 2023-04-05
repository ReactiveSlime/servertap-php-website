<!DOCTYPE html>

<head>
    <title>My Page</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<?php
require_once('settings.php');
require_once('functions.php');

// Get online player data, world data, and server data
$online_players = @file_get_contents($address . '/v1/players/', false, $context);

if ($online_players === false) {
    $error = error_get_last();
    exit('Could not connect to server: ' . $error['message']);
}

$world_json = file_get_contents($address . '/v1/worlds/' .  $world, false, $context);
$server_json = file_get_contents($address . '/v1/server/', false, $context);

// Decode world and server data from JSON to PHP objects
$world_json = json_decode($world_json);
$server_json = json_decode($server_json);

// Calculate and format memory usage
$freeMemoryGB = number_format($server_json->health->freeMemory / (1024 * 1024 * 1024), 2);
$maxMemoryGB = number_format($server_json->health->maxMemory / (1024 * 1024 * 1024), 2);

// Display server stats
echo '<div class="container">';
echo '<div class="server-stats">Server Stats:</div>';
echo 'The Server TPS Is <span class="tps">' . $server_json->tps . '</span><br>';
echo 'Server Memory <span class="memory">' . $freeMemoryGB . ' GB</span>/<span class="memory">' . $maxMemoryGB . ' GB</span><br>';
echo 'The Server Uptime Is <span class="uptime">' . secondsToTime($server_json->health->uptime) . '</span><br>';
$weather = $world_json->storm ? ($world_json->thundering ? "Thunder" : "Storm") : "Clear";
echo 'The Server Weather Is <span class="weather">' . $weather . '</span><br><br>';

// Display player stats
$online_players = json_decode($online_players);
//Everything below is to do with players
if ($online = count($online_players)) {
    // Display number of online players
    echo '<div class="online-players">' . "There " . ($online == 1 ? "is" : "are") . " $online player" . ($online == 1 ? "" : "s") . " online</div><br>";


    // Create an array of formatted strings for each player
    $player_html = array_map(function ($player) use ($address, $context) {
        $player_data = json_decode(file_get_contents($address . "/v1/players/" . $player->uuid, false, $context));
        // Gets the players X,Y,Z and converts it into a more usable format
        $location = $player_data->location;
        $player_x = (int) $location[0];
        $player_y = (int) $location[1];
        $player_z = (int) $location[2];

        // Construct the location text
        $player_location_text = " X:" . $player_x . " Y:" . $player_y . " Z:" . $player_z;

        // Define the dimension names
        $dimension_names = [
            "NORMAL" => "Overworld",
            "NETHER" => "The Nether",
            "END" => "The End",
        ];

        // Check what dimension the player is currently in
        $dimension = $player_data->dimension;
        if (isset($dimension_names[$dimension])) {
            // Use the dimension name to construct the output message
            $player_location = $dimension_names[$dimension] . ": " . $player_location_text;
        } else {
            // If the dimension is not recognized, output an error message
            $player_location = "Unknown Dimension: " . $player_location_text;
        }
// Displays data about each player
return sprintf(
    '<div class="player">
        <a href="player.php?uuid=%s">%s</a> <br>
        <img class="player-avatar" src="https://crafatar.com/avatars/%s" width="64px" alt="Minecraft player head"/>
        <div class="player-location">%s</div>
        <div class="player-health">Health %s <img src="./assets/img/heart.png" /></div>
        <div class="player-hunger">Hunger %s <img src="./assets/img/food.png" /></div>
    </div>',
    $player->uuid,
    $player->displayName,
    $player->uuid,
    $player_location,
    $player_data->health,
    $player_data->hunger,
);

    }, $online_players);

    // Join player HTML strings with line breaks
    echo implode("<br>", $player_html);
} else {
    echo "There are no players online";
}
echo '</div>';
?>
</body>

</html>

