<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Allergy.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare allergy object
$Allergy = new Allergy($db);

//get user_id
$Allergy->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

$stmt = $Allergy->readUser();
$num = $stmt->rowCount();

$Allergy_arr=array();
$Allergy_arr["Allergy"]=array();


if($num > 0){
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      extract($row);

      $Allergy=array(
          "allergy_item_id" => $allergy_item_id,
          "allergy_itemName" => $allergy_itemName

      );
      array_push($Allergy_arr["Allergy"], $Allergy);
  }
      http_response_code(200);

      echo json_encode($Allergy_arr);

}
else{
    http_response_code(404);

    echo json_encode(array("message" => "No allergies exist."));
}
?>
