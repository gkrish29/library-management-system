<?php
 $dbHost = "localhost";
 $dbName = "lms";
 $dbUser = "root";
 $dbPassword = "";
 
 // Create a database connection
 $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
 
 // Check if the connection was successful
 if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
 }

?>
