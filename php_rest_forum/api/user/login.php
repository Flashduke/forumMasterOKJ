<?php
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';


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

if ($num > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);

    //set properties
    $user->id = $row['id'];
    $user->confirm = $row['password'];
    $user->picture = $row['picture'];
    $user->createdAt = $row['createdAt'];
    $user->role = $row['role'];
    $user->name = $row['name'];

    if (md5($user->password) == $user->confirm) {
        $secret_key = "5767fdf5-bfbb-47de-82e8-4dd68ac9cd15";
        $issuer_claim = "THE_ISSUER"; // this can be the servername
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 60; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $user->id,
                "email" => $user->email,
                "picture" => $user->picture,
                "createdAt" => $user->createdAt,
                "role" => $user->role,
                "name" => $user->name
            )
        );

        http_response_code(200);

        $jwt = JWT::encode($token, $secret_key);
        echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "email" => $user->email,
                "expireAt" => $expire_claim
            )
        );
    } else {
        $asd = md5($user->password).' '. $user->confirm;
        http_response_code(401);
        echo json_encode(array("message" => "Login failed.", "password" => $asd));
    }
}