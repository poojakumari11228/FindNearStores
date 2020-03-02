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


//Function to calculate distance
function calcDist($lat_A, $long_A, $lat_B, $long_B)
{

    $distance = sin(deg2rad($lat_A))
        * sin(deg2rad($lat_B))
        + cos(deg2rad($lat_A))
        * cos(deg2rad($lat_B))
        * cos(deg2rad($long_A - $long_B));

    $distance = (rad2deg(acos($distance))) * 69.09;

    return $distance;
}

//check if field is empty
if (empty($code)) {
    echo '<h1>Please Enter the Zip Code!</h1>';
} else {

    // get stores of entered zip code
    $sql = "SELECT * FROM stores left join zip_codes on zip_codes.zip_code = stores.zip_code where zip_codes.zip_code=$code";
    $result = $conn->query($sql);
    //If that zip code exixts
    if ($conn->affected_rows > 0) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $lat_a = $row['latitude'];
        $long_a = $row['longitude'];

        // get stores for calculation the distance
        $sql2 = "SELECT * FROM stores left join zip_codes on zip_codes.zip_code = stores.zip_code";
        $result2 = $conn->query($sql2);

        if ($conn->affected_rows > 0) {
            while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
                $lat_b = $row2['latitude'];
                $long_b = $row2['longitude'];

                //calculate distance b/w the entered zip's lat/long and all others
                $dist[$row2['zip_code']] = calcDist($lat_a, $long_a, $lat_b, $long_b);
                // store other details with zipcode
                $details[$row2['zip_code']] = [$row2['name'], $row2['state'], $row2['city'], $row2['address'], $row2['phone']];
            }
        }
        //Sort the calculated distance to find the closest one
        asort($dist);
        $display = '<h1>5 Closest Stores : </h1>';
        //column names -- LOGICAL PART
        $detail_columns = ['Name : ', 'State : ', 'City : ', 'Address : ', 'Phone : '];
        //counter -- LOGICAL PART
        $count = 0;
        $first = true;

        //store contents to display
        foreach ($dist as $key => $value) {
            $count++;
            if ($count > 5 && $first == true) {
                $display .= ' <h1>Other Near Stores </h1>';
                $first = false;
            }
            $display .= '<div class="content"> 
                    <h2>Zipcode : ' . $key . '</h2> <h3>Distance : ' . $value . '</h3> <br>';
            for ($i = 0; $i < 5; $i++) {
                $display .= $detail_columns[$i] . $details[$key][$i] . ' <br>';
            }
            $display .= '</div>';
        }
        echo $display;
    } else echo '<h1>Data of entered zip code is not found in database.</h1>';
}

?>