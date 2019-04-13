<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  // include database and object files
  include_once '../config/database.php';
  include_once '../objects/RateRecipe.php';

  //get database connection
  $database = new Database();
  $db = $database->getConnection();

  $RateRecipe = new RateRecipe($db);

  if(isset($_GET['user_id']) && isset($_GET['recipe_id']) && isset($_GET['rating'])) {
    $RateRecipe->user_id = $_GET['user_id'];
    $RateRecipe->recipe_id = $_GET['recipe_id'];
    $RateRecipe->rating = $_GET['rating'];

    if($RateRecipe->updateLikes()){
      http_response_code(200);
      echo json_encode(array("message"=>"Rating for recipe was updated"));
    }
    else{
      http_response_code(404);
      echo json_encode(array("message"=>"Unable to update recipe rating"));
    }
  }
  else{
    http_response_code(404);
    echo json_encode(array("message"=>"Incomplete data..."));
  }







?>
