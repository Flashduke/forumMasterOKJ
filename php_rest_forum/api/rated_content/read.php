<?php
//headers
header('Access-Control-Allow-Origin: http://localhost:3000');

header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/RatedContent.php';

//instantiate database and connect
$database = new Database();
$db = $database->connect();

//instantiate rated posts object
$rated_posts = new RatedContent($db, 'post');

//instantiate rated comments object
$rated_comments = new RatedContent($db, 'comment');

$userName = isset($_GET['profile']) ? $_GET['profile'] : die();
$rated_posts->userName = $userName;
$rated_comments->userName = $userName;

//rated posts query
$result_p = $rated_posts->read();

//rated comments query
$result_c = $rated_comments->read();

//get row count
$num_p = $result_p->rowCount();
$num_c = $result_c->rowCount();

//check if any rated_posts
if ($num_p > 0 || $num_c > 0) {
    //rated array
    $rated_arr = array();
    $rated_arr['likedPosts'] = array();
    $rated_arr['dislikedPosts'] = array();
    $rated_arr['likedComments'] = array();
    $rated_arr['dislikedComments'] = array();
    while ($row = $result_p->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        if ($thumbsUp == 1) array_push($rated_arr['likedPosts'], $postID);
        if ($thumbsDown == 1) array_push($rated_arr['dislikedPosts'], $postID);
    }

    while ($row = $result_c->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        if ($thumbsUp == 1) array_push($rated_arr['likedComments'], $commentID);
        if ($thumbsDown == 1) array_push($rated_arr['dislikedComments'], $commentID);
    }

    //turn to JSON and output
    echo json_encode($rated_arr);
    http_response_code(200);
} else {
    //no rated content
    echo json_encode(
        array('message' => 'No Rated Content')
    );
    http_response_code(204);
}
