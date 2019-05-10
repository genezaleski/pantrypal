<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../objects/RateRecipe.php';

    //setup database conn
    $database = new Database();
    $db = $database->getConnection();

    // prepare RateRecipe object
    $RateRecipe = new RateRecipe($db);

    if(isset($_GET['recipe_id'])) {
      $RateRecipe->recipe_id = $_GET['recipe_id'];
      $RateRecipe->getLikes();
    }

    if($RateRecipe->recipe_id != null){

        $Rating_arr = array(
          'recipe_id' => $RateRecipe->recipe_id,
          'likes' => $RateRecipe->likes,
          'dislikes' => $RateRecipe->dislikes
        );
      echo json_encode($Rating_arr, JSON_PRETTY_PRINT);
    }
    else{
      http_response_code(404);

      echo json_encode(array("message"=> "Recipe does not exist"));
    }
?>
