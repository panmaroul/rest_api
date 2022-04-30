<?php
// Headers

use config\Database;
use models\Energy;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Energy.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$energy = new Energy($db);

// Blog post query
$result = $energy->read();
// Get row count
$num = $result->rowCount();

// Check if any posts
if($num > 0) {
    // Post array
    $posts_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'country' => $country,
            'population' => $population,
            'world_share' => $world_share,
            'non_renewable' => $non_renewable,
            'co2_emiss_per_capita' => $co2_emiss_per_capita,
            'country_share_of_world_co2' => $country_share_of_world_co2,
            'co2_emiss_one_year_change' => $co2_emiss_one_year_change
        );

        // Push to "data"
        array_push($posts_arr, $post_item);
        // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($posts_arr);

} else {
    // No Posts
    echo json_encode(
        array('message' => 'No Energy Found')
    );
}