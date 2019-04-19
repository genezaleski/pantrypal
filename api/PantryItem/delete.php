<?php
  // required headers
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  // include database and object file
  include_once '../config/database.php';
  include_once '../objects/PantryItem.php';

  // get database connection
  $database = new Database();
  $db = $database->getConnection();

  // prepare allergy object
  $PantryItem = new PantryItem($db);

  // get allergy_item_id id

  if (isset($_GET['item_name']) && isset($_GET['user_id'])) {
    $PantryItem->item_name = $_GET['item_name'];
    $PantryItem->user_id = $_GET['user_id'];
  }
  else{
    http_response_code(404);
    echo json_encode(array("message" => "Data is incomplete..."));
  }

  // delete the product
  if($PantryItem->delete()){
      //200 ok
      http_response_code(200);
      echo json_encode(array("message" => "A PantryItem was deleted."));
  }
  else{
      //503 service unavailable
      http_response_code(503);
      echo json_encode(array("message" => "Unable to delete PantryItem"));
  }
?>
