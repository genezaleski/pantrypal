<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate user object
include_once '../objects/RateRecipe.php';
 
$database = new Database();
$db = $database->getConnection();
 
$rateRecipe = new RateRecipe($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!empty($data->recipe_id) &&
    !empty($data->user_id) &&
    !empty($data->rating)
){
    // set user property values
    $rateRecipe->recipe_id = $data->recipe_id;
    $rateRecipe->user_id = $data->user_id;
    $rateRecipe->rating = $data->rating;

    // create the rateRecipe
    if($rateRecipe->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "{$rateRecipe} was created."));
    }

    // if unable to create the rateRecipe, tell the guest
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the guest
        echo json_encode(array("message" => "Unable to create {$rateRecipe}."));
    }
}

// tell the guest data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the guest
    echo json_encode(array("message" => "Unable to create rating, data is incomplete."));
}
?>
