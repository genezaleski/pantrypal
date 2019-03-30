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
        font: bold;
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
    .relatedImg{
    display: block;
    max-width:300px;
    max-height: 300px;
    width: auto;
    height: auto;
    -webkit-filter: grayscale(0%);
    margin-bottom: 15px;
    z-index: 1;
}
.relatedImg:hover{
    -webkit-filter: grayscale(100%); 
}
.relatedTitle{
    position: absolute;
    display: block;
    float: left;
    margin-top: -150px;
    margin-left: 50px;
    margin-right: -150px;
    z-index: 2;
    font-family: 'results_font';
    pointer-events: none;
    font-size: 25px;
    color: white;
    text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
    max-width:250px;
    word-wrap:break-word;
}
.likeBtn{
    max-height: 50px;
    max-width: 50px;
}

.disLikeBtn{
    max-height: 50px;
    max-width: 50px;
    transform: rotate(180deg);
}

</style>

<?php
include 'navbar.php';

$recipeID = $_GET['id'];

$my_api_key = '"X-RapidAPI-Key :322dc0a550msh6970a9bebfd18b2p1010fcjsnaed4930a9684"';
$other_api_key = '"X-RapidAPI-Key : 4af690163bmshda5b867e43cbc70p155394jsnc38cedc3355a"';

//Retrieving recipe info
$api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $recipeID . "/information";
$cmd = "curl -H " . $my_api_key . " " . $api_url;
$recipeInfo = json_decode(shell_exec($cmd), true);

//Retriving recipe instructions broken into steps
//$analysed_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/".$recipeID."/analyzedInstructions?stepBreakdown=false";
//$instrCmd = "curl -H " . $api_key . " " . $analysedRecipe;
//$recipeInstr = json_decode(shell_exec($instrCmd),true);

//Retriving similar recipies to add as links
$related_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $recipeID . "/similar";
$relatedCmd = "curl -H " . $other_api_key . " " . $related_url;
$relatedLinks = json_decode(shell_exec($relatedCmd), true);

?>

<title><?php $recipeInfo['title']; ?></title>

<body>
    <br>

    <div class="maincontent">
        <div class="main">
            <?php 
            //Title and image of recipe
            echo    '<h1>' . $recipeInfo['title'] . '</h1>
            <div class="mainImage"><img src="'.$recipeInfo['image'].'"> </div>';

            ?>
            <!-- Like/Dislike Buttons -->
            <input type = "image" alt="" src="images/likeButton.png" onClick="changeLikeImage()" name="likeBtn" class="likeBtn" id="likeBtn"/>
            <input type = "image" alt="" src="images/likeButton.png" onClick="changeDisLikeImage()" name="disLikeBtn" class="disLikeBtn" id="disLikeBtn"/>
            

        <script language="javascript">

        function changeLikeImage() {
            console.log(document.getElementById("likeBtn").src);
            if (document.getElementById("likeBtn").src.includes('likeButton.png')){
                //Checking if the disLiked button is checked and unchecking it
                if(document.getElementById("disLikeBtn").src.includes('disLikedButton.png')){
                    document.getElementById("disLikeBtn").src = "images/likeButton.png";
                }
                document.getElementById("likeBtn").src = "images/likedButton.png";
                //Set recipe to liked here using MySQL
            }
            else {
                document.getElementById("likeBtn").src = "images/likeButton.png";
                //Set like value to null since the button was unliked
            }
        }
        function changeDisLikeImage() {
            console.log(document.getElementById("disLikeBtn").src);
            if (document.getElementById("disLikeBtn").src.includes('likeButton.png')){
                //Checking if the liked button is checked and unchecking it
                if(document.getElementById("likeBtn").src.includes('likedButton.png')){
                    document.getElementById("likeBtn").src = "images/likeButton.png";
                }
                document.getElementById("disLikeBtn").src = "images/disLikedButton.png";
                //Set recipe to disliked here using MySQL
            }
            else {
                document.getElementById("disLikeBtn").src = "images/likeButton.png";
                //Set value to null since the disLike button was unclicked
            }
        }
        </script>


        <?php
            echo '<br><h2> Ingredients </h2>';
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

            echo 'Comments will go down here when ready';
            
            ?>
        </div>
        <div class="sidelinks">
            <?php 
            echo '<h2> You may also like these Recipes</h2>';
            //Generating related links with clickable images
            for ($r = 0; $r < $relatedLinks[$r]; $r++) {
                echo '<div class = "related">
                 <a href=recipeInfo.php?id='.$relatedLinks[$r]['id'].'><img class="relatedImg" src="https://spoonacular.com/recipeImages/'. $relatedLinks[$r]['image'] .'" alt="recipeImage" style="width:100%;"></a>
                 <div class="relatedTitle">' .$relatedLinks[$r]['title']. '</div>
            </div>';
            };;
            ?>
        </div>
    </div>
</body>

</html> 