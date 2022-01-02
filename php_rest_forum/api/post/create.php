<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum post object
$post = new Post($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$post->communityID = $data->communityID;
$post->content = $data->content;
$post->picture = $data->picture;
$post->userID = $data->userID;
$post->thumbsDowns = $data->thumbsDowns;
$post->thumbsUps = $data->thumbsUps;
$post->title = $data->title;

//create post
if ($post->create()) {
    echo json_encode(
        array('message' => 'Post Created')
    );
}
else {
    echo json_encode(
        array('message' => 'Post Not Created')
    );
}