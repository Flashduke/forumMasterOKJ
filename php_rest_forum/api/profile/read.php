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

//forum profile query
$result = $profile->read();
//get row count
$num = $result->rowCount();

//check if any profiles
if ($num > 0) {
    //profile array
    $profiles_arr = array();
    $profiles_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $profile_item = array(
            'id' => $id,
            'createdAt' => $createdAt,
            'description' => $description,
            'name' => $name,
            'followerCount' => $followerCount,
            'icon' => $icon,
            'banner' => $banner
        );

        //push to "data"
        array_push($profiles_arr['data'], $profile_item);
    }

    //turn to JSON and output
    echo json_encode($profiles_arr);
    http_response_code(200);
} else {
    //no profiles
    echo json_encode(
        array('message' => 'No Profiles Found')
    );
    http_response_code(204);
}
