<?php
//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

include_once '../../config/Database.php';
include_once '../../models/Community.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum community object
$community = new community($db);

//get name
$community->name = isset($_GET['name']) ? str_replace('_', ' ', $_GET['name']) : die();

//get community
$community->readSingle();

//create array
$community_arr = array(
    'id' => $community->id,
    'createdAt' => $community->createdAt,
    'description' => $community->description,
    'name' => $community->name,
    'memberCount' => $community->memberCount,
    'icon' => $community->icon,
    'banner' => $community->banner
);

//make JSON
print_r(json_encode($community_arr));
