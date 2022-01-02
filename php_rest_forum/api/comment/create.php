<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Comment.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum comment object
$comment = new Comment($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$comment->content = $data->content;
$comment->postID = $data->postID;
$comment->userID = $data->userID;
$comment->thumbsDowns = $data->thumbsDowns;
$comment->thumbsUps = $data->thumbsUps;

//create comment
if ($comment->create()) {
    echo json_encode(
        array('message' => 'Comment Created')
    );
}
else {
    echo json_encode(
        array('message' => 'Comment Not Created')
    );
}