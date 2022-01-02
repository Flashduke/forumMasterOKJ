<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

//set ID to update
$community->id = $data->id;

//delete community
if ($community->delete()) {
    echo json_encode(
        array('message' => 'Community Deleted')
    );
}
else {
    echo json_encode(
        array('message' => 'Community Not Deleted')
    );
}