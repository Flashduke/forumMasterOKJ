<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Comment.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum comment object
$comment = new Comment($db);

//get ID
$comment->id = isset($_GET['id']) ? $_GET['id'] : die();

//get comment
$comment->readSingle();

//create array
$comment_arr = array(
    'id' => $comment->id,
    'postTitle' => $comment->postTitle,
    'userName' => $comment->userName,
    'createdAt' => $comment->createdAt,
    'content' => $comment->content,
    'postID' => $comment->postID,
    'userID' => $comment->userID,
    'thumbsDowns' => $comment->thumbsDowns,
    'thumbsUps' => $comment->thumbsUps
);

//make JSON
print_r(json_encode($comment_arr));
