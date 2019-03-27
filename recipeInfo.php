<style>
    .maincontent {
        
        display: grid;
        grid-template-columns: 70% 30%;
    }

    body {
        background: lightblue;
        margin: 25px;
    }
    .title {
        font-size: 20px;
    }

    .recipe {
        width: 60%;
    }

    .related {
        list-style-position: inside;
    }

    img {
        max-height: 30%;
        max-width: 30%;
    }
    .a {
        float: right;

        right: 5px;
    }

    .relatedImages {
        height: 10%;
        width: 13%;
    }
</style>

<?php
include 'navbar.php';

$recipeID = $_GET['id'];

$api_key = '"X-RapidAPI-Key :322dc0a550msh6970a9bebfd18b2p1010fcjsnaed4930a9684"';

//Retrieving recipe info
$api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $recipeID . "/information";
$cmd = "curl -H " . $api_key . " " . $api_url;
$recipeInfo = json_decode(shell_exec($cmd), true);

//Retriving recipe instructions broken into steps
//$analysed_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/".$recipeID."/analyzedInstructions?stepBreakdown=false";
//$instrCmd = "curl -H " . $api_key . " " . $analysedRecipe;
//$recipeInstr = json_decode(shell_exec($instrCmd),true);

//Retriving similar recipies to add as links
$related_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $recipeID . "/similar";
$relatedCmd = "curl -H " . $api_key . " " . $related_url;
$relatedLinks = json_decode(shell_exec($relatedCmd), true);

?>

<title><?php $recipeInfo['title']; ?></title>

<body>
    <br>

    <div class="maincontent">
        <div class="main">
            <?php 
            //Title and image of recipe
            echo    '<br><br><div class="title">' . $recipeInfo['title'] . '</div><br>
            <div class="mainImage"><img src="'.$recipeInfo['image'].'"> </div>
            <br><h2> Ingredients </h2>';



            //Loop that generates a list of the ingredients used
            for ($i = 0; $i < $recipeInfo['extendedIngredients'][$i]; $i++) {
                $amount = $recipeInfo['extendedIngredients'][$i]['amount'];
                $unit = $recipeInfo['extendedIngredients'][$i]['unit'];
                $ingrName = $recipeInfo['extendedIngredients'][$i]['name'];
                echo '<div class = "ingredients">' . $amount, " ",  $unit, " ",  $ingrName . ' </div>';
            }



            //Instructions with error handling for no instructions found
            $instructions = $recipeInfo['instructions'];
            if ($instructions == "") {
                $instructions = "Whoops, there are no available instructions for this recipe.";
            }
            echo '<br><h2> Insructions </h2> 
    <div class="recipe">' . $instructions . '</div><br>';

            //Unfinished, but will hopefully print a better list of instructions than just a dense paragraph
            //for($j = 0; $j < sizeOf($recipeInstr); $j++){
            //    echo '<h3>' .$recipeInstr[$j]['name'].'</h3>';
            //    for($n = 0; $n < $recipeInstr[$j]['steps']; $n++){
            //        echo '<div class="instruction">'. $n , " " , $recipeInstr[$j]['steps'][$n]['step'] . '<div>';
            //    }
            //}

            ?>
        </div>
        <div class="sidelinks">
            <?php 
            //Unfinished (Needs  to be styled correctly)
            //Generating related links with clickable images
            for ($r = 0; $r < $relatedLinks[$r]; $r++) {
                echo '<div class = "related">
            <a href = "recipeInfo.php?id=' . $relatedLinks[$r]['id'] . '">' . $relatedLinks[$r]['title'] . '<br>
            <img src = "https://spoonacular.com/recipeImages/'.$relatedLinks[$r]['image'].'"></a>
            <br>
            </div>';
            };;
            ?>
        </div>
    </div>
</body>

</html> 