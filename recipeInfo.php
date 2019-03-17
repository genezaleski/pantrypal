<?php
include 'navbar.php';

$recipieID = $_GET['id'];

$api_key = '"X-RapidAPI-Key :322dc0a550msh6970a9bebfd18b2p1010fcjsnaed4930a9684"';
$api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/".$recipieID."/information";
$cmd = "curl -H " . $api_key . " " . $api_url;
$recipeInfo = json_decode(shell_exec($cmd),true);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php $recipeInfo['title']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    
</head>
<body>
    <br>
    <?php
        echo    '<br><div clacc="image"><image src="' . $recipeInfo['image']. '"> </div>
                <div class="title">' .$recipeInfo['title']. '</div>
                <br><div class="recipie">' . $recipeInfo['instructions'] . '</div>';

    ?>  
</body>
</html>
