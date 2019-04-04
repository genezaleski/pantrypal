<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/CommentRecipe.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare comment object
$comment = new CommentRecipe($db);

// set comment_id property of record to read
$comment->recipe_id = isset($_GET['recipe_id']) ? $_GET['recipe_id'] : die();

// read the details of comment to be edited
$comment->readOne();

if($comment->name!=null){
    // create array
    $comment_arr = array(
        "comment_id" =>  $comment->comment_id,
        "user_id" => $comment->user_id,
        "recipe_id" => $comment->recipe_id,
        "comment_text" => $comment->comment_text,
        "comment_time" => $comment->comment_time
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($comment_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user comment does not exist
    echo json_encode(array("message" => "Comment does not exist."));
}
?>