<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate allergy object
include_once '../objects/Allergy.php';
 
$database = new Database();
$db = $database->getConnection();
 
$allergy = new Allergy($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(!empty($data->allergy_itemName)&&
    !empty($data->user_id)
){
    // set allergy property values
    $allergy->allergy_itemName = $data->allergy_itemName;
    $allergy->user_id = $data->user_id;

    // create the allergy
    if($allergy->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the allergy
        echo json_encode(array("message" => "Allergy was created."));
    }

    // if unable to create the allergy, tell the guest
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the guest
        echo json_encode(array("message" => "Unable to create allergy."));
    }
}

// tell the guest data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the guest
    echo json_encode(array("message" => "Unable to create allergy, data is incomplete."));
}
?>
