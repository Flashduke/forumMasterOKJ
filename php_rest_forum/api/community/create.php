<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Community.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum community object
$community = new Community($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$community->description = $data->description;
$community->name = $data->name;

//create community
if ($community->create()) {
    echo json_encode(
        array('message' => 'Community Created')
    );
}
else {
    echo json_encode(
        array('message' => 'Community Not Created')
    );
}