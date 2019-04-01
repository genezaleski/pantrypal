<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and user files
include_once '../config/database.php';
include_once '../objects/PantryItem.php';

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$PantryItem = new PantryItem($db);

// query pantry
$stmt = $PantryItem->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // pantry array
    $PantryItem_arr=array();
    $PantryItem_arr["PantryItem"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $Pantry_item=array(
            "pantry_item_id" => $pantry_item_id,
            "item_name" => $item_name,
            "user_id" => $user_id
        );

	array_push($PantryItem_arr["PantryItem"], $Pantry_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show users data in json format
    echo json_encode($PantryItem_arr, JSON_PRETTY_PRINT);

}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no pantry items found
    echo json_encode(
        array("message" => "No pantry items found.")
    );
}
?>
