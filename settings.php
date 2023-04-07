<?php
$address = "http://your-ip-or-address:4567";

$opts = [
    "http" => [
        "method" => "GET",
        "header" => "key: Your-ServerTap-Password\r\n",
    ]
];
$context = stream_context_create($opts);

$console_password = "your password";

//Query /v1/worlds for your world IDs
$world = "d6a5b4ab-5a7f-48cd-9775-cba5a4cf097f";
$world_nether = "ccdb84ed-db14-4f9b-a76d-4b748ac30522";
$world_the_end = "2d2f3727-fac8-4225-b796-5d54b9fca282";

?>