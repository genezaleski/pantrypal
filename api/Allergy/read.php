<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and user files
include_once '../config/database.php';
include_once '../objects/Allergy.php';

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Allergy = new Allergy($db);

// query allergy
$stmt = $Allergy->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // allergy array
    $Allergy_arr=array();
    $Allergy_arr["Allergy"]=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $Allergy=array(
            "allergy_item_id" => $allergy_item_id,
            "allergy_itemName" => $allergy_itemName,
            "user_id" => $user_id
        );

	array_push($Allergy_arr["Allergy"], $Allergy);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show users data in json format
    echo json_encode($Allergy_arr, JSON_PRETTY_PRINT);

}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no allergy items found
    echo json_encode(
        array("message" => "No allergy items found.")
    );
}
?>
