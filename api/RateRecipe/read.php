<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and user files
include_once '../config/database.php';
include_once '../objects/RateRecipe.php';

// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$rating = new RateRecipe($db);

// query ratings
$stmt = $rating->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // ratings array
    $rating_arr=array();
    $rating_arr["ratings"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackover:flow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $rating_item=array(
            "ratedRecipe_id" => $ratedRecipe_id,
            "recipe_id" => $recipe_id,
            "user_id" => $user_id,
            "rating" => $rating
        );

	array_push($rating_arr["ratings"], $rating_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show users data in json format
    echo json_encode($rating_arr);

}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No ratings found.")
    );
}
?>
