<?php
require_once('settings.php');

// Gets the UUID from the URL and exits if one is not provided
if (!isset($_GET["uuid"])) {
    exit("No UUID specified");
}

// Gets player data using the provided UUID
$player_url = $address . '/v1/players/' . htmlspecialchars($_GET["uuid"]);
$player_json = @file_get_contents($player_url, false, $context);

// Checks if player is on or off
if ($player_json === false) {
    // Player is offline
    $name_json = file_get_contents("https://sessionserver.mojang.com/session/minecraft/profile/" . $_GET["uuid"]);
    $name = json_decode($name_json);
    if ($name === null) {
        echo "Invalid UUID proviced";
    } else
    echo $name->name . " is offline";
} else {
    // Player is online
    $player = json_decode($player_json);
    echo $player->displayName . "</br>";
    echo "Health: " . ceil($player->health) . "</br>";
    echo "Hunger: " . ceil($player->hunger) . "</br>";
    // Vars for Health and Hunger
    $health = ceil($player->health);
    $max_health = 20;
    $hearts = $health / 2;
    $empty_hearts = $max_health / 2 - $hearts;
    $hunger = ceil($player->hunger);
    $max_hunger = 20;
    $food = $hunger / 2;
    $empty_food = $max_hunger / 2 - $food;


    // Loop through all hearts and empty hearts
    if ($health % 2 == 0) {
        for ($i = 0; $i < $hearts; $i++) {
            echo "<img src='./assets/img/heart.png' style='width: 1rem;'>";
        }
        for ($i = 0; $i < $empty_hearts; $i++) {
            echo "<img src='./assets/img/heart_empty.png' style='width: 1rem;'>";
        }
    } else {
        for ($i = 0; $i < $hearts - 1; $i++) {
            echo "<img src='./assets/img/heart.png' style='width: 1rem;'>";
        }
        echo "<img src='./assets/img/heart_half.png' style='width: 1rem;'>";
        for ($i = 0; $i < $empty_hearts - 1; $i++) {
            echo "<img src='./assets/img/heart_empty.png' style='width: 1rem;'>";
        }
    }
    echo "&nbsp&nbsp&nbsp";
    //hunger bar
    //same as health bar but with hunger and flip the order of the images
    // so empty hunger first then half then full
    if ($hunger % 2 == 0) {
    
        for ($i = 0; $i < $empty_food; $i++) {
            echo "<img src='./assets/img/food_empty.png' style='width: 1rem;'>";
        }
        for ($i = 0; $i < $food; $i++) {
            echo "<img src='./assets/img/food.png' style='width: 1rem;'>";
        }
    } else {
        for ($i = 0; $i < $empty_food - 1; $i++) {
            echo "<img src='./assets/img/food_empty.png' style='width: 1rem;'>";
        }
        echo "<img src='./assets/img/food_half.png' style='width: 1rem;'>";
        for ($i = 0; $i < $food - 1; $i++) {
            echo "<img src='./assets/img/food.png' style='width: 1rem;'>";
        }
    }
    echo "</br>";
// Gets the players X,Y,Z and converts it into a more usable format
$location = $player->location;
$player_x = (int) $location[0];
$player_y = (int) $location[1];
$player_z = (int) $location[2];

// Construct the location text
$player_location_text = "X,Y,Z " . $player_x . " / " . $player_y . " / " . $player_z;

// Define the dimension names
$dimension_names = [
    "NORMAL" => "Overworld",
    "NETHER" => "The Nether",
    "END" => "The End",
];

// Check what dimension the player is currently in
$dimension = $player->dimension;
if (isset($dimension_names[$dimension])) {
    // Use the dimension name to construct the output message
    echo $dimension_names[$dimension] . ": " . $player_location_text;
    //dynmap ifram can be added here if wanted
} else {
    // If the dimension is not recognized, output an error message
    echo "Unknown Dimension: " . $player_location_text;
}

}
