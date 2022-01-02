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

//forum comment query
$result = $comment->read();
//get row count
$num = $result->rowCount();

//check if any comments
if ($num > 0) {
    //comment array
    $comments_arr = array();
    $comments_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $comment_item = array(
            'id' => $id,
            'createdAt' => $createdAt,
            'content' => $content,
            'postID' => $postID,
            'postTitle' => $postTitle,
            'userID' => $userID,
            'userName' => $userName,
            'thumbsDowns' => $thumbsDowns,
            'thumbsUps' => $thumbsUps
        );

        //push to "data"
        array_push($comments_arr['data'], $comment_item);
    }
    
    //turn to JSON and output
    echo json_encode($comments_arr);
} 
else {
    //no comments
    echo json_encode(
        array('message' => 'No Comments Found')
    );
}