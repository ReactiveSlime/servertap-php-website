<?php
require_once('func.php');
require_once('settings.php');





if ($_GET["uuid"] == "") {
    exit("No UUID specified");
}
if ($player == NULL){
    $name = file_get_contents('https://api.mojang.com/user/profiles/' . $_GET["uuid"] . '/names');
    //check to see if request was successful
    if ($name == false) {
        echo "The UUID provided is invalid.";
        exit;
    } else {
        //get the last name in the array
        $name = json_decode($name);
        $name = $name[count($name)-1]->name;
        echo "    <title>" . $name . "</title>";
        echo  $name . " is offline.";
    }
    exit;
} 


echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "    <meta charset='UTF-8'>";
echo "    <meta http-equiv='X-UA-Compatible' content='IE=edge'>";
echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "    <title>" . $player->displayName . "</title>";
echo "    <link rel='stylesheet' href='./assets/css/style.css'>";
echo "</head>";
echo "<body>";

echo "<h1>" . $player->displayName . "</h1>";

//health
echo "<div class='health-hunger'>";
echo "<p>Health: " . ceil($player->health) . "</p>";
echo "<p>hunger: " . ceil($player->hunger) . "</p>";

/* #region Health-Hunger */
//health bar
$health = ceil($player->health);
$max_health = 20;
$hearts = $health / 2;
$empty_hearts = $max_health / 2 - $hearts;
$hunger = ceil($player->hunger);
$max_hunger = 20;
$food = $hunger / 2;
$empty_food = $max_hunger / 2 - $food;
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
echo "</div>";
echo "<div class=location>";
/* #endregion */
/* #region dynmap */
//chage text based on dimension
if ($player->dimension == "NORMAL") {
    echo "<p>I am currently in the overworld at ";
    //get x y z coords from array called location
    $location = $player->location;
    echo " X: " . (int)$location[0] . " Y: " . (int)$location[1] . " Z: " . (int)$location[2] . "</p>";
    echo "<a href='https://map.reactivesli.me/?worldname=world&mapname=flat&zoom=6&x=" . (int)$location[0] . "&y=64&z=" . (int)$location[2] . "'target='_blank'> View my location on dynmap</a><br>";
    //iframe with dynmap

    echo "<iframe class='dynmap' marginheight='0' marginwidth='0' height='100%' width='100%' display='block' border='none' outline='none' margin='none' src='https://map.reactivesli.me/?worldname=world&mapname=flat&zoom=6&x=" . (int)$location[0] . "&y=64&z=" . (int)$location[2] . "' scrolling='no' seamless='yes' allowfullscreen='yes' frameborder='0' style='height: 79vh;'></iframe>";


} elseif ($player->dimension == "NETHER") {
    echo "<p>I am currently in the nether at";
    $location = $player->location;
    echo " X: " . (int)$location[0] . " Y: " . (int)$location[1] . " Z: " . (int)$location[2] . "</p>";
    echo "<a href='https://map.reactivesli.me/?worldname=world_nether&mapname=flat&zoom=6&x=" . (int)$location[0] . "&y=64&z=" . (int)$location[2] . "'target='_blank'> View my location on dynmap</a><br>";
    //iframe with dynmap
    echo "<iframe class='dynmap' marginheight='0' marginwidth='0' height='100%' width='100%' display='block' border='none' outline='none' margin='none' src='https://map.reactivesli.me/?worldname=world_nether&mapname=flat&zoom=6&x=" . (int)$location[0] . "&y=64&z=" . (int)$location[2] . "' scrolling='no' seamless='yes' allowfullscreen='yes' frameborder='0' style='height: 79vh;'></iframe>";
} elseif ($player->dimension == "END") {
    echo "<p>I am currently in the end at";
    $location = $player->location;
    echo " X: " . (int)$location[0] . " Y: " . (int)$location[1] . " Z: " . (int)$location[2] . "</p>";
    echo "<a href='https://map.reactivesli.me/?worldname=world_the_end&mapname=flat&zoom=6&x=" . (int)$location[0] . "&y=64&z=" . (int)$location[2] . "'target='_blank'> View my location on dynmap</a><br>";
    //iframe with dynmap
    echo "<iframe class='dynmap' marginheight='0' marginwidth='0' height='100%' width='100%' display='block' border='none' outline='none' margin='none' src='https://map.reactivesli.me/?worldname=world_the_end&mapname=flat&zoom=6&x=" . (int)$location[0] . "&y=64&z=" . (int)$location[2] . "' scrolling='no' seamless='yes' allowfullscreen='yes' frameborder='0' style='height: 79vh;'></iframe>";
}
/* #endregion */
echo "</div>";
echo "<br>";

?>

</body>
</html>
