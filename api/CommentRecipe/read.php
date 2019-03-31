<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and user files
include_once '../config/database.php';
include_once '../objects/CommentRecipe.php';

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$comment = new CommentRecipe($db);

// query comments
$stmt = $comment->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // comments array
    $comments_arr=array();
    $comments_arr["comments"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackover:flow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $comment_item=array(
            "comment_id" => $comment_id,
            "user_id" => $user_id,
            "recipe_id" => $recipe_id,
            "comment_text" => $comment_text,
            "comment_time" => $comment_time
        );

        array_push($comments_arr["comments"], $comment_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show users data in json format
    echo json_encode($comments_arr, JSON_PRETTY_PRINT);

}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no comments found
    echo json_encode(
        array("message" => "No comments found.")
    );
}
?>