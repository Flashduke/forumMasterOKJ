<?php
//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

include_once '../../config/Database.php';
include_once '../../models/Profile.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum profile object
$profile = new Profile($db);

//get name
$profile->name = isset($_GET['name']) ? $_GET['name'] : die();

//get profile
$profile->readSingle();

//create array
$profile_arr = array(
    'id' => $profile->id,
    'createdAt' => $profile->createdAt,
    'description' => $profile->description,
    'name' => $profile->name,
    'followerCount' => $profile->followerCount,
    'icon' => $profile->icon,
    'banner' => $profile->banner
);

//make JSON
print_r(json_encode($profile_arr));
