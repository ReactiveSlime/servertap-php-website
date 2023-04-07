<?php
include_once ('settings.php');
// Check if the user has the correct header value
if (@$_SERVER['HTTP_CONSOLE'] !== $console_password) {
    // If they don't have the correct header value, display a message
    echo "Unauthorized access!";
    exit;
  }
  ?>

<!DOCTYPE html>
<html>
  <head>
    <title>Console</title>
    <link rel="stylesheet" href="./assets/css/command.css">
  </head>
  <body>
    <div class="container">
      <h1>Console</h1>
      <form action="./send_command.php" method="post">
        <div class="form-group">
          <label for="command">Command:</label>
          <input type="text" id="command" name="command">
        </div>
        <button type="submit" class="btn">Send</button>
      </form>
    </div>
  </body>
</html>
