<?php
$address = "http://your-domain.com:4567";

// Create a stream
$opts = [
    "http" => [
        "method" => "GET",
        "header" => "key: you-password\r\n",
    ]
];
// DOCS: https://www.php.net/manual/en/function.stream-context-create.php
$context = stream_context_create($opts);

//query http://your-domain.com:4567/v1/worlds/ for world IDs
$overworld = "world_ID";
$nether = "nether_ID";
$the_end = "the_end_id";
?>
