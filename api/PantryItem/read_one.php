<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/PantryItem.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare recipe object
$PantryItem = new PantryItem($db);

// set ID property of recipe to read

if(isset($_GET['user_id'])){
  $PantryItem->user_id = $_GET['user_id'];
  $stmt = $PantryItem->readOne();

  $PantryItem_arr=array();
  $PantryItem_arr["Pantry"]=array();

  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    extract($row);

      // create array
      $PantryItem_item = array(
          "pantry_item_id" =>  $pantry_item_id,
          "item_name" => $item_name
      );

      array_push($PantryItem_arr["Pantry"], $PantryItem_item);

  }
    //200 OK
    http_response_code(200);
    echo json_encode($PantryItem_arr);
}

else{
    //404 Not found
    http_response_code(404);
    echo json_encode(array("message" => "Pantry does not exist"));
}
?>
