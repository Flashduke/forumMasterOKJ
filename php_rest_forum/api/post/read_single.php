<?php
//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
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
    'author' => $post->author,
    'communityName' => $post->communityName,
    'title' => $post->title,
    'content' => $post->content,
    'commentCount' => $post->commentCount,
    'createdAt' => $post->createdAt,
    'thumbsDowns' => $post->thumbsDowns,
    'thumbsUps' => $post->thumbsUps
);

//make JSON
print_r(json_encode($post_arr));
http_response_code(200);
