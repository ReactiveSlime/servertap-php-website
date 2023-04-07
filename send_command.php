<?php
include_once ('settings.php');
// Check if the user has the correct header value
if (@$_SERVER['HTTP_CONSOLE'] !== $console_password) {
    // If they don't have the correct header value, display a message
    echo "Unauthorized access!";
    exit;
  }

// If they do have the correct header value, continue with the program
// Set the variables for the API request
// Set the API endpoint URL
$url = "$address/v1/server/exec";

// Set the POST data for the API request
$command = $_POST["command"];

// Set the API endpoint URL
$url = "$address/v1/server/exec";

// Set the POST data for the API request
$data = array(
  "command" => $command,
  "time" => "1"
);

// Set the headers for the API request
$headers = array(
  "accept: */*",
  "key: $key",
  "Content-Type: application/x-www-form-urlencoded"
);

// Create the cURL request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Add the CURLOPT_VERBOSE option to capture the raw payload
curl_setopt($ch, CURLOPT_VERBOSE, true);
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

// Execute the cURL request and get the response
$response = curl_exec($ch);

// Check if there was an error with the cURL request
if (curl_errno($ch)) {
  echo "<div class='container'>Error: " . curl_error($ch) . "</div>";
  exit;
}

// Close the cURL request
curl_close($ch);

// Display the API response
echo "<div class='container'><pre>" . htmlspecialchars($response) . "</pre></div>";
?>
