<?php
$baseurl = $_SERVER['SERVER_NAME'];
//echo $baseurl;
if($baseurl=='localhost')
{
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sanjaysoftwaredb";
}else{
 $servername = "localhost";
 $username = "sanjaysoftware_db";
 $password = "india@vbd121";
 $dbname = "sanjaysoftware_db";
}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

