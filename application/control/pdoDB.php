<?php
## MySQL Connection Parameters
$db_server = 'localhost:3306';
$db_name = 'smf2wp';
$db_user = 'root';
$db_password = 'oluTOLA#835!';
try {
      $conn = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_password);
      // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
      echo "Error: " . $e->getMessage();
    }
?>
