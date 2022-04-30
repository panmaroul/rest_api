<?php

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

// Get ID
$columnName = isset($_GET['column_name']) ? $_GET['column_name'] : die();

// Get post
$energy->read_single($columnName);
$post_arr = $energy->res;

// Make JSON
print_r(json_encode($post_arr));