<?php
//headers
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Content-Type: application/json');
header('Access-Control-Allow-Credentials: true');

include_once '../../config/Database.php';
include_once '../../models/Comment.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate forum comment object
$comment = new Comment($db);

//get param
if (isset($_GET['postID'])) {
    $comment->postID = $_GET['postID'];
    $comment->condition = 'postID';
} else if (isset($_GET['profile'])) {
    $comment->userName = $_GET['profile'];
    $comment->condition = 'author';
} else die();

//forum comment query
$result = $comment->read();
//get row count
$num = $result->rowCount();

//check if any comments
if ($num > 0) {
    //comment array
    $comments_arr = array();
    $comments_arr['comments'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $comment_item = array(
            'id' => $id,
            'postID' => $postID,
            'author' => $author,
            'postTitle' => $postTitle,
            'communityName' => $communityName,
            'content' => $content,
            'createdAt' => $createdAt,
            'thumbsDowns' => $thumbsDowns,
            'thumbsUps' => $thumbsUps,
        );

        //push to "comments"
        array_push($comments_arr['comments'], $comment_item);
    }

    //turn to JSON and output
    echo json_encode($comments_arr);
    http_response_code(200);
} else {
    //no comments
    echo json_encode(
        array('message' => 'No Comments Found'. $comment->postID)
    );
    http_response_code(204);
}
