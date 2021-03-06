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
$community = new Community($db);

//forum community query
$result = $community->read();
//get row count
$num = $result->rowCount();

//check if any communities
if ($num > 0) {
    //commmunity array
    $communities_arr = array();
    $communities_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $community_item = array(
            'id' => $id,
            'createdAt' => $createdAt,
            'description' => $description,
            'name' => $name,
            'memberCount' => $memberCount,
            'icon' => $icon,
            'banner' => $banner
        );

        //push to "data"
        array_push($communities_arr['data'], $community_item);
    }

    //turn to JSON and output
    echo json_encode($communities_arr);
    http_response_code(200);
} else {
    //no communities
    echo json_encode(
        array('message' => 'No Communities Found')
    );
    http_response_code(204);
}
