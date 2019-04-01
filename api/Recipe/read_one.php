<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/Recipe.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare recipe object
$Recipe = new Recipe($db);

// set ID property of recipe to read
$url = '/api/Recipe/read_one/';
$ch = curl_init($url);
$readString = http_build_query($data, '', '&');
$response = curl_exec($ch);
curl_close($ch);

$Recipe->recipe_id = curl_unescape($respone, $recipe_id);

// read the details of recipe to be edited
$Recipe->readOne();

if($Recipe->name!=null){
    // create array
    $Recipe_arr = array(
        "recipe_id" =>  $Recipe->recipe_id,
        "api_name" => $Recipe->api_name,
        "api_recipe_id" => $Recipe->api_recipe_id,
        "title" => $Recipe->title,
        "author" => $Recipe->author,
        "recipe_link" => $Recipe->recipe_link
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($Recipe_arr);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user recipe does not exist
    echo json_encode(array("message" => "Recipe does not exist."));
}
?>
