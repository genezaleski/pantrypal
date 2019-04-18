<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/User.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare User object
$user = new User($db);

// set ID property of User to read

if(isset($_GET['user_name'])){
  $user->user_name = $_GET['user_name'];
  $user->readOne();
}

if($user->user_name != null){
    // create array
    $user_arr = array(
        "user_id" =>  $user->user_id,
        "oauth_token" => $user->oauth_token,
        "user_name" => $user->user_name
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($user_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user user does not exist
    echo json_encode(array("message" => "User does not exist."));
}
?>