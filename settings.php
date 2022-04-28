<?php
$address = "http://your-domain.com:4567";

// Create a stream
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "key: your-password\r\n",
    ]
];
// DOCS: https://www.php.net/manual/en/function.stream-context-create.php
$context = stream_context_create($opts);

//query http://your-domain.com:4567/v1/worlds/ for world IDs
$overworld = "2093f60c-04b8-4d34-a695-584663a0f0f4";
$nether = "bab1d5e4-0ba9-466d-8b72-b4aebbdd2ab4";
$the_end = "cd97df83-37d7-4bfc-8308-96fe7b976185";


$players_url= $address . '/v1/players/';
$server_stats_url = $address . '/v1/server/';
$world_stats_url = $address . '/v1/worlds/' . $overworld;

$players = file_get_contents( $players_url, false,  $context,);
$server_stats = file_get_contents( $server_stats_url, false, $context,);
$world_stats = file_get_contents( $world_stats_url, false, $context,);
$world_stats = json_decode($world_stats);
$server = json_decode($server_stats);

$user_url = $address . '/v1/players/' . htmlspecialchars($_GET["uuid"]);
$user = file_get_contents( $user_url, false,  $context,);
$player = json_decode($user);

?>
