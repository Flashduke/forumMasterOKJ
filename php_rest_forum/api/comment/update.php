<?php
//JWT
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;

//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Comment.php';
include_once '../jwt.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum comment object
$comment = new Comment($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));
//get JWT from header
$jwt = get_bearer_token();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
} else if ($jwt) {

    try {

        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        //set ID to update
        $comment->userID = $decoded->data->id;
        $comment->id = $data->id;

        $comment->content = $data->content;

        //create comment
        if ($comment->update()) {
            echo json_encode(
                array('message' => 'Comment Updated')
            );
            http_response_code(200);
        } else {
            echo json_encode(
                array('message' => 'Comment Not Updated')
            );
            http_response_code(403);
        }
    } catch (Exception $e) {

        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}
