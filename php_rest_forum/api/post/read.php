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

$post->communityURL = isset($_GET['community']) ? str_replace('_', ' ', $_GET['community']) : '';
$post->profileURL = isset($_GET['profile']) ? str_replace('_', ' ', $_GET['profile']) : '';

//forum post query
$result = $post->read();
//get row count
$num = $result->rowCount();

//check if any posts
if ($num > 0) {
    //post array
    $posts_arr = array();
    $posts_arr['posts'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $id,
            'author' => $author,
            'communityName' => $communityName,
            'title' => $title,
            'content' => $content,
            'createdAt' => $createdAt,
            'thumbsDowns' => $thumbsDowns,
            'thumbsUps' => $thumbsUps,
        );

        //push to posts array
        array_push($posts_arr['posts'], $post_item);
    }
    
    //turn to JSON and output
    echo json_encode($posts_arr);
    http_response_code(200);
} 
else {
    //no posts
    echo json_encode(
        array('message' => 'No Posts Found')
    );
}