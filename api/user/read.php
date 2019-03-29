<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
<<<<<<< Updated upstream
 
// include database and user files
include_once '../config/database.php';
include_once '../objects/user.php';
 
// instantiate database and user object
=======

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

// instantiate database and product object
>>>>>>> Stashed changes
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new user($db);

// query users
$stmt = $user->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // users array
    $users_arr=array();
    $users_arr["users"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackover:flow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $user_item=array(
            "user_id" => $user_id,
            "user_name" => $user_name,
            "oauth_token" => $oauth_token,
        );
<<<<<<< Updated upstream
 
        array_push($users_arr["users"], $user_item);
=======

        array_push($products_arr["records"], $product_item);
>>>>>>> Stashed changes
    }

    // set response code - 200 OK
    http_response_code(200);
<<<<<<< Updated upstream
 
    // show users data in json format
    echo json_encode($users_arr);
=======

    // show products data in json format
    echo json_encode($products_arr);
>>>>>>> Stashed changes

}else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No users found.")
    );
}
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
?>
