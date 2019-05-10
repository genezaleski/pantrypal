<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  include_once '../config/database.php';
  include_once '../objects/RateRecipe.php';

  //setup database connection
  $database = new Database();
  $db = $database->getConnection();

  // prepare RateRecipe object
  $RateRecipe = new RateRecipe($db);

  if(isset($_GET['user_id']) && isset($_GET['recipe_id'])){
    $RateRecipe->user_id = $_GET['user_id'];
    $RateRecipe->recipe_id = $_GET['recipe_id'];
    $RateRecipe->getRatingUser();
  }

  if($RateRecipe->rating != null){
    $Rating_arr = array(
      // 'user_id' => $RateRecipe->user_id,
      // 'recipe_id' => $RateRecipe->recipe_id,
      'rating' => $RateRecipe->rating
    );

    http_response_code(200);
    echo json_encode($Rating_arr, JSON_PRETTY_PRINT);
  }
  else{
    http_response_code(404);
    echo json_encode(array("message"=> "Rating does not exist"));
  }
?>
