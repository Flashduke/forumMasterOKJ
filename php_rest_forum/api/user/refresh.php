<?php
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;
//headers
header('Access-Control-Allow-Origin: localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';
include_once '../jwt.php';


//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum user object
$user = new User($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$user->email = $data->email;

//forum user query
$result = $user->login();

//get row count
$num = $result->rowCount();

if ($num > 0 && isset($_COOKIE['refreshToken'])) {
    $row = $result->fetch(PDO::FETCH_ASSOC);

    //set properties
    $user->id = $row['id'];
    $user->role = $row['role'];

    try {
        $decoded = JWT::decode($_COOKIE['refreshToken'], $secret_key, array('HS256'));

        if ($decoded->data->id == $user->id) {
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 10; //not before in seconds
            $expire_claim = $issuedat_claim + 60; // expire time in seconds
            $accessToken = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "id" => $user->id,
                    "email" => $user->email,
                    "role" => $user->role,
                    "name" => $user->name
                )
            );
    
            //encode access token
            $jwt = JWT::encode($accessToken, $secret_key);
            echo json_encode(
                array(
                    "message" => "Successful token refresh.",
                    "accessToken" => $jwt,
                    "email" => $user->email,
                    "role" => $user->role,
                    "expireAt" => $expire_claim
                )
            );
            
            http_response_code(200);
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Refresh failed."));
        }
    } catch (Exception $e) {
        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} else {
    http_response_code(401);
}
