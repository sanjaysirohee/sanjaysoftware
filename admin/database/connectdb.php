<?php
$baseurl = $_SERVER['SERVER_NAME'];
if($baseurl=='localhost'){
    define("HOSTNAME","localhost");
    define("USERNAME","root");
    define("PASSWORD","");
    define("DATABASE","sanjaysoftware_db");

}else{

    define("HOSTNAME","localhost");
    define("USERNAME","sanjaysoftware_db");
    define("PASSWORD","india@vbd121");
    define("DATABASE","sanjaysoftware_db");
}



$con=new mysqli(HOSTNAME,USERNAME,PASSWORD,DATABASE) or die("Unable to connect");
?>
