<style>
body{
    background: lightblue;
    margin: 25px;
}
.title{
    font-size: 20px;
}
.recipe{
    width: 75%;
}
</style>

<?php
include 'navbar.php';

$recipieID = $_GET['id'];

$api_key = '"X-RapidAPI-Key :322dc0a550msh6970a9bebfd18b2p1010fcjsnaed4930a9684"';
$api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/".$recipieID."/information";
$cmd = "curl -H " . $api_key . " " . $api_url;
$recipeInfo = json_decode(shell_exec($cmd),true);

?>

<title><?php $recipeInfo['title']; ?></title>
    <br>
    <?php
        echo    '<br><br><div class="title">' .$recipeInfo['title']. '</div><br>
                <div clacc="image"><image src="' . $recipeInfo['image']. '"> </div>
                <br><h2> Ingredients </h2>';
        for($i = 0; i < $recipeInfo['extendedIngredients'][$i]; $i++){
            $amount = $recipeInfo['extendedIngredients'][$i]['amount'];
            $unit = $recipeInfo['extendedIngredients'][$i]['unit'];
            $ingrName = $recipeInfo['extendedIngredients'][$i]['name'];
            echo '<div class = "ingredients">' . $amount , " " ,  $unit , " " ,  $ingrName .' </div>';
        }
        $instructions = $recipeInfo['instructions'];
        if($instructions == ""){
            $instructions = "Whoops, there are no available instructions for this recipe.";
        }                
        echo '<br><h2> Insructions </h2> 
        <div class="recipe">' . $instructions . '</div><br>';

    ?>  
</body>
</html>
