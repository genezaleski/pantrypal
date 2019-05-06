<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/RateRecipe.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare rating object
$RateRecipe = new RateRecipe($db);

// set ID property of rating to read
if(isset($_GET['recipe_id']) && isset($_GET['user_id'])){
  $RateRecipe->recipe_id = $_GET['recipe_id'];
  $RateRecipe->user_id = $_GET['user_id'];
  $RateRecipe->readOne();
}

// read the details of recipe to be edited
if($RateRecipe->recipe_id != null){
    // create array
    $Recipe_arr = array(
        "ratedRecipe_id" =>  $RateRecipe->ratedRecipe_id,
        "recipe_id" => $RateRecipe->recipe_id,
        "user_id" => $RateRecipe->user_id,
        "rating" => $RateRecipe->rating
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
