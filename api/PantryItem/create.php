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
    // set user property values
    $item->user_name = $data->item_name;
    $item->oauth_token = $data->user_id;

    // create the user
    if($item->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "User was created."));
    }

    // if unable to create the user, tell the guest
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the guest
        echo json_encode(array("message" => "Unable to create user."));
    }
}

// tell the guest data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the guest
    echo json_encode(array("message" => "Unable to create user, data is incomplete."));
}
?>
