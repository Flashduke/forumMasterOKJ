<?php
//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Credentials: true');
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
$user->confirm = $data->confirm;
/* $user->picture = $data->picture;
$user->role = $data->role; */
$user->name = $data->name;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);

} else if (empty($user->email) || empty($user->password) || empty($user->name) || empty($user->confirm)) {
    http_response_code(422);

    echo json_encode(
        array('message' => 'Empty Fields')
    );
} else if (filter_var($user->email, FILTER_VALIDATE_EMAIL) == false) {
    http_response_code(422);

    echo json_encode(
        array('message' => 'Invalid Email')
    );
} else if ($user->password != $user->confirm) {
    http_response_code(422);

    echo json_encode(
        array('message' => 'Empty Fields')
    );
} else if ($user->signup()) { //signup user
    http_response_code(201);

    echo json_encode(
        array('message' => 'Sign Up Successful')
    );
} else {
    http_response_code(400);

    echo json_encode(
        array('message' => 'Sign Up Not Successful')
    );
}
