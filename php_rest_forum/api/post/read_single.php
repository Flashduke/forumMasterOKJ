<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum post object
$post = new Post($db);

//get ID
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//get post
$post->readSingle();

//create array
$post_arr = array(
    'id' => $post->id,
    'communityID' => $post->communityID,
    'communityName' => $post->communityName,
    'content' => $post->content,
    'picture' => $post->picture,
    'createdAt' => $post->createdAt,
    'userID' => $post->userID,
    'userName' => $post->userName,
    'thumbsDowns' => $post->thumbsDowns,
    'thumbsUps' => $post->thumbsUps,
    'title' => $post->title
);

//make JSON
print_r(json_encode($post_arr));
