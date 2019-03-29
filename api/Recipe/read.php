<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and user files
include_once '../config/database.php';
include_once '../objects/Recipe.php';

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$Recipe = new Recipe($db);

// query users
$stmt = $Recipe->read();
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

        array_push($Recipe_arr["Recipes"], $Recipe_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show users data in json format
    echo json_encode($Recipe_arr);

}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No recipes found.")
    );
}
?>
