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

  if(isset($_GET["user_id"])){
    $RateRecipe->user_id = $_GET["user_id"];
    $stmt = $RateRecipe->getLikesUser();

    $LikedRecipe_arr=array();
    $LikedRecipe_arr["Liked Recipes"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

      extract($row);

      $LikedRecipe_item=array(
        "recipe_id" => $recipe_id
      );

      array_push($LikedRecipe_arr["Liked Recipes"], $LikedRecipe_item);
    }

    http_response_code(200);
    echo json_encode($LikedRecipe_arr["Liked Recipes"], JSON_PRETTY_PRINT);
  }
  else{
    http_response_code(404);
    echo json_encode(array("message"=> "User does not exist"));
  }
?>
