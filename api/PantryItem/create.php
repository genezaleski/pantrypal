<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate pantry item object
include_once '../objects/PantryItem.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new PantryItem($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!empty($data->item_name)&&
    !empty($data->user_id)
){
    // set pantry item property values
    $item->item_name = $data->item_name;
    $item->user_id = $data->user_id;

    // create the pantry item
    if($item->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the pantry item
        echo json_encode(array("message" => "Pantry item was created."));
    }

    // if unable to create the pantry item, tell the guest
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the guest
        echo json_encode(array("message" => "Unable to create pantry item."));
    }
}

// tell the guest data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the guest
    echo json_encode(array("message" => "Unable to create pantry item, data is incomplete."));
}
?>
