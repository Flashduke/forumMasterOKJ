<?php
//JWT
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;

//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Join.php';
include_once '../jwt.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum rated content object
$join = new Join($db);

//get data
$join->communityID = isset($_GET['communityID']) ? $_GET['communityID'] : die();

//get JWT from header
$jwt = get_bearer_token();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
} else if ($jwt) {
    try {

        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
        
        $join->userID = $decoded->data->id;

        if ($join->check()) {
            echo json_encode(
                array('state' => true)
            );
            http_response_code(200);
        } else {
            echo json_encode(
                array('state' => false, 'asd' => $join->userID . ' ' . $join->communityID)
            );
            http_response_code(200);
        }
    } catch (Exception $e) {
        http_response_code(403);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
}
