<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Community.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum community object
$community = new community($db);

//get ID
$community->id = isset($_GET['id']) ? $_GET['id'] : die();

//get community
$community->readSingle();

//create array
$community_arr = array(
    'id' => $community->id,
    'createdAt' => $community->createdAt,
    'description' => $community->description,
    'name' => $community->name
);

//make JSON
print_r(json_encode($community_arr));