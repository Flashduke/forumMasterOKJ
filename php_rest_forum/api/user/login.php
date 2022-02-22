<?php
require "../../vendor/autoload.php";

use \Firebase\JWT\JWT;
//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
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
$user->password = $data->password;

//forum user query
$result = $user->login();

//get row count
$num = $result->rowCount();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
} else if ($num > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);

    //set properties
    $user->id = $row['id'];
    $user->confirm = $row['password'];
    $user->picture = $row['picture'];
    $user->createdAt = $row['createdAt'];
    $user->role = $row['role'];
    $user->name = $row['name'];

    if (md5($user->password) == $user->confirm) {
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
        $expire_claim = $issuedat_claim + 86400;
        $refreshToken = array(
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
        //encode refresh token 
        $user->refreshToken = JWT::encode($refreshToken, $secret_key);

        //set refreshToken in DB
        if (!$user->setRefreshToken()) {
            http_response_code(400);
            echo json_encode(array("message" => "Login failed."));
        }
        
        //set httponly cookie
        setcookie('refreshToken', $user->refreshToken, $expire_claim, '/', '', false, true);

        //encode access token
        $jwt = JWT::encode($accessToken, $secret_key);
        echo json_encode(
            array(
                "message" => "Successful login.",
                "accessToken" => $jwt,
                "email" => $user->email,
                "role" => $user->role,
                "expireAt" => $expire_claim
            )
        );

        http_response_code(200);
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Login failed."));
    }
}
