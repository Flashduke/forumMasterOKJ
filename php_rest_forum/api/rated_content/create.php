<?php
//JWT
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;

//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/RatedContent.php';
include_once '../jwt.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

$table_name = isset($_GET['type']) && ($_GET['type'] == 'comment' || $_GET['type'] == 'post') ? $_GET['type'] : die();

//instantiate forum rated content object
$rated_content = new RatedContent($db, $table_name);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//get JWT from header
$jwt = get_bearer_token();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
} else if ($data->thumbsUp == $data->thumbsDown) {
    echo json_encode(
        array('message' => 'You cannot like and dislike the same content!')
    );
    http_response_code(403);
} else if ($jwt) {
    try {

        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
        $rated_content->id = $data->id;
        $rated_content->userID = $decoded->data->id;
        $rated_content->thumbsDown = $data->thumbsDown ? 1 : 0;
        $rated_content->thumbsUp = $data->thumbsUp ? 1 : 0;

        if ($rated_content->check()) {
            echo json_encode(
                array('message' => 'You cannot rate the same content twice!')
            );
            http_response_code(403);
        } else if ($rated_content->create()) { //create rated
            echo json_encode(
                array('message' => ucfirst($table_name) . ' Rated')
            );
            http_response_code(200);
        } else {
            echo json_encode(
                array('message' => ucfirst($table_name) . ' Not Rated')
            );
            http_response_code(403);
        }
    } catch (Exception $e) {
        http_response_code(403);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}
