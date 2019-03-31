<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate Recipe object
include_once '../objects/Recipe.php';

$database = new Database();
$db = $database->getConnection();

$Recipe = new Recipe($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(!empty($data->api_name)
  &&!empty($data->api_recipe_id)
  &&!empty($data->title)
  &&!empty($data->author)
  &&!empty($data->recipe_link)
){
    // set user property values
    $Recipe->api_name = $data->api_name;
    $Recipe->api_recipe_id = $data->api_recipe_id;
    $Recipe->title = $data->title;
    $Recipe->author = $data->author;
    $Recipe->recipe_link = $data->recipe_link;

    // create the user
    if($user->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "{$Recipe} was created."));
    }

    // if unable to create the recipe, tell the guest
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the guest
        echo json_encode(array("message" => "Unable to create {$Recipe}."));
    }
}

// tell the guest data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the guest
    echo json_encode(array("message" => "Unable to create Recipe, data is incomplete."));
}
?>
