<!-- FORMATE OF DIST ARRAY
     dist = array(
         "zip_code" => "distance"
     ) 

 -->
<!-- FORMATE OF DETAILS ARRAY 
    detail = array(
        "zip_code" => [name, address, city, state, phone]
    )
 -->

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

    // get stores of entered zip code
    $sql = "SELECT * FROM stores right join zip_codes on zip_codes.zip_code = stores.zip_code where zip_codes.zip_code=$code";
    $result = $conn->query($sql);
    //If that zip code exixts
    if ($conn->affected_rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $lat_a = $row['latitude'];
        $long_a = $row['longitude'];

        
    // get stores for calculation the distance
    $sql2 = "SELECT * FROM stores right join zip_codes on zip_codes.zip_code = stores.zip_code";
    $result2 = $conn->query($sql2);

    if ($conn->affected_rows > 0) {
        while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
            $lat_b = $row2['latitude'];
            $long_b = $row2['longitude'];

              }
    }
 
    }
    else echo '<h1>Data of entered zip code is not found in database.</h1>';

}

?>