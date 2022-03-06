<?php
//JWT
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;

//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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
$rated_content = new RatedContent($db, $table_name . 's');

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//get JWT from header
$jwt = get_bearer_token();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
} else if ($jwt) {
    try {

        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
        $rated_content->postID = $data->postID;
        $rated_content->userID = $decoded->data->id;

        if ($rated_content->delete()) { //delete rated
            echo json_encode(
                array('message' => ucfirst($table_name) . ' Rating Deleted')
            );
            http_response_code(200);
        } else {
            echo json_encode(
                array('message' => ucfirst($table_name) . ' Rating Not Deleted')
            );
            http_response_code(403);
        }
    } catch (Exception $e) {
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
        http_response_code(403);
    }
}
