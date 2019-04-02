<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate comment object
include_once '../objects/CommentRecipe.php';
 
$database = new Database();
$db = $database->getConnection();
 
$comment = new CommentRecipe($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!empty($data->user_id)&&
    !empty($data->recipe_id)&&
    !empty($data->comment_text)
){
    // set comment property values
    $comment->user_id = $data->user_id;
    $comment->recipe_id = $data->recipe_id;
    $comment->comment_text = $data->comment_text;

    // create the comment
    if($comment->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Comment was created."));
    }

    // if unable to create the Comment, tell the guest
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the guest
        echo json_encode(array("message" => "Unable to create comment."));
    }
}

// tell the guest data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the guest
    echo json_encode(array("message" => "Unable to create comment, data is incomplete."));
}
?>
