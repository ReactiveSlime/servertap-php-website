<?php
    require_once('settings.php');
    require_once('functions.php');

    // Get online player data, world data, and server data
    $online_players = file_get_contents($address . '/v1/players/', false, $context);
    $world_json = file_get_contents($address . '/v1/worlds/' .  $world, false, $context);
    $server_json = file_get_contents($address . '/v1/server/', false, $context);

    // Decode world and server data from JSON to PHP objects
    $world_json = json_decode($world_json);
    $server_json = json_decode($server_json);

    // Calculate and format memory usage
    $freeMemoryGB = number_format($server_json->health->freeMemory / (1024 * 1024 * 1024), 2);
    $maxMemoryGB = number_format($server_json->health->maxMemory / (1024 * 1024 * 1024), 2);
    
    // Display server stats
    echo "The Server TPS Is " . $server_json->tps;
    echo "</br>";
    echo "Server Memory $freeMemoryGB GB/$maxMemoryGB GB";
    echo "</br>";
    echo "The Server Uptime Is " . secondsToTime($server_json->health->uptime);
    echo "</br>";
    $weather = $world_json->storm ? ($world_json->thundering ? "Thunder" : "Storm") : "Clear";
    echo "The Server Weather Is $weather";
    echo "</br></br>";
    
    // Display player stats
    $online_players = json_decode($online_players);

    if ($online = count($online_players)) {
        // Display number of online players
        echo "There " . ($online == 1 ? "is" : "are") . " $online player" . ($online == 1 ? "" : "s") . " online<br>";
    
        // Create an array of formatted strings for each player
        $player_html = array_map(function($player) {
            return sprintf(
                '%s <a href="player.php?uuid=%s">View Player</a><br><img src="https://crafatar.com/avatars/%s" width="64px" alt="Minecraft player head"/>',
                htmlspecialchars($player->displayName), // Escape display name for safety
                htmlspecialchars($player->uuid), // Escape UUID for safety
                htmlspecialchars($player->uuid) // Escape UUID for safety
            );
        }, $online_players);
    
        // Join player HTML strings with line breaks
        echo implode("<br>", $player_html);
    } else {
        echo "There are no players online";
    }
?>
