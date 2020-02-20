
<?php


// Make Connection to db
include_once("connect.php");

// Variables Declaration
$code =  $_GET['code'];
$lat_a = 0.0;
$lat_b = 0.0;
$long_a = 0.0;
$long_b = 0.0;
$dist = array();
$details = array();



//check if field is empty
if (empty($code)) {
    echo '<h1>Please Enter the Zip Code!</h1>';
} else {

}

?>