<?php
include 'navbar.php';

$recipieID = $_GET['id'];

echo $recipieID;
$api_key = "322dc0a550msh6970a9bebfd18b2p1010fcjsnaed4930a9684";
$api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/$recipieID/information";
$cmd = "curl -H " . $api_key . " " . $api_url;
$output_arr = json_decode(shell_exec($cmd),true);

//$response = Unirest\Request::get("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/$recipieID/information",
//  array(
//    "X-RapidAPI-Key" => "322dc0a550msh6970a9bebfd18b2p1010fcjsnaed4930a9684"
//  )
//);


echo $output_arr["sourceUrl"];
?>