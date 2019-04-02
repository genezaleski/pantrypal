<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and user files
include_once '../config/database.php';
include_once '../objects/Recipe.php';

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Recipe = new Recipe($db);

// query users
$recipe_id = json_decode(file_get_contents("php://input"));
if($recipe_id->recipe_id != null){
  $stmt = $Recipe->read_one($recipe_id);
}
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // users array
    $Recipe_arr=array();
    $Recipe_arr["Recipes"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackover:flow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $Recipe_item=array(
            "recipe_id" => $recipe_id,
            "api_name" => $api_name,
            "api_recipe_id" => $api_recipe_id,
            "title" => $title,
            "author" => $author,
            "recipe_link" => $recipe_link
        );

        array_push($Recipe_arr["Recipe"], $Recipe_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show users data in json format
    echo json_encode($Recipe_arr, JSON_PRETTY_PRINT);

}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no recipes found
    echo json_encode(
        array("message" => "No recipes found.")
    );
}
?>
