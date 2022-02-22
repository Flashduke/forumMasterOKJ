<?php
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;
//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
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

$user->refreshToken = $_COOKIE['refreshToken'];

//forum user query
$result = $user->findRefreshToken();

//get row count
$num = $result->rowCount();

if (isset($_COOKIE['refreshToken'])) {
    $row = $result->fetch(PDO::FETCH_ASSOC);

    //set property
    $user->id = $row['id'];

    try {
        $decoded = JWT::decode($_COOKIE['refreshToken'], $secret_key, array('HS256'));
        if ($user->id == $decoded->data->id) {
            
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
                        "expireAt" => $expire_claim
                        )
                    );
                    
                    http_response_code(200);
                }
                else {
                    echo json_encode(array(
                        "message" => "Forbidden."
                    ));
                    http_response_code(403);
                }
    } catch (Exception $e) {
        
        echo json_encode(array(
            "message" => "Forbidden.",
            "error" => $e->getMessage()
        ));
        http_response_code(403);
    }
} else {
    echo json_encode(array("message" => "Refresh failed."));
    http_response_code(403);
}
