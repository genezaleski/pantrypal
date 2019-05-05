<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Recipe.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare recipe object
$Recipe = new Recipe($db);

// set ID property of recipe to read

if(isset($_GET['recipe_id'])){
  $Recipe->recipe_id = $_GET['recipe_id'];
  $Recipe->readOne();
}
elseif(isset($_GET['api_name']) && isset($_GET['api_recipe_id'])){
  $Recipe->api_name = $_GET['api_name'];
  $Recipe->api_recipe_id = $_GET['api_recipe_id'];
  $Recipe->readOneAPI();
}

if($Recipe->recipe_id != null){
    // create array
    $Recipe_arr = array(
        "recipe_id" =>  $Recipe->recipe_id,
        "api_name" => $Recipe->api_name,
        "api_recipe_id" => $Recipe->api_recipe_id,
        "title" => $Recipe->title,
        "author" => $Recipe->author,
        "recipe_link" => $Recipe->recipe_link
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($Recipe_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user recipe does not exist
    echo json_encode(array("message" => "Recipe does not exist."));
}
?>
