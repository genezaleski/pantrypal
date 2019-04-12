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

// query comments
$stmt = $comment->recipePage();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // comments array
    $comments_arr=array();
    $comments_arr["comments"]=array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        // create array
        $comment_item = array(
            "comment_id" =>  $comment_id,
            "user_id" => $user_id,
            "recipe_id" => $recipe_id,
            "comment_text" => $comment_text,
            "comment_time" => $comment_time
        );
    
        array_push($comments_arr["comments"], $comment_item);
    }

    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($comments_arr, JSON_PRETTY_PRINT);
}

else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user comment does not exist
    echo json_encode(array("message" => "No comments found."));
}
?>