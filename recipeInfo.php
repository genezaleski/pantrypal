<link rel="stylesheet" type="text/css" href="stylesheets/recipeInfoStyle.css">

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

//Pulling in likes and dislikes  to be used 
$likeDataCmd = "curl http://52.91.254.222/api/RateRecipe/read.php";
$decodedLikeData = json_decode(shell_exec($likeDataCmd), true);

$commentCmd = "curl http://52.91.254.222/api/CommentRecipe/read.php";
$decodedComments = json_decode(shell_exec($commentCmd), true);

$rExists = false;
for ($r = 0; $r < sizeof($rListDecode['Recipes']); $r++) {
    if ($rListDecode['Recipes'][$r]['api_recipe_id'] == $recipeID) {
        $rExists = true;
    }
}
if ($rExists == false) {
    $createRecipeUrl = 'http://52.91.254.222/api/Recipe/create.php';
    $recipeJSON = array(
        'api_name' => 'spoon',
        'api_recipe_id' => $recipeID,
        'title' => $recipeInfo['title'],
        'author' => $recipeInfo['creditText'],
        'recipe_link' => $recipeInfo['sourceUrl']
    );
    $recipeJSONEncoded = json_encode($recipeJSON);

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'content' => $recipeJSONEncoded,
            'header' =>  "Content-Type: application/json\r\n" .
                "Accept: application/json\r\n"
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($createRecipeUrl, false, $context);
    $response = json_decode($result);
}

?>

<title><?php $recipeInfo['title']; ?></title>

<body>
    <br>

    <div class="maincontent">
        <div class="main">
            <?php
            //Title and image of recipe
            echo    '<h1>' . $recipeInfo['title'] . '</h1>
            <div class="mainImage"><img src="' . $recipeInfo['image'] . '"> </div>';

            ?>
            <!-- Like/Dislike Buttons -->
            <input type="image" alt="" src="images/likeButton.png" onClick="changeLikeImage()" name="likeBtn" class="likeBtn" id="likeBtn" />
            <input type="image" alt="" src="images/likeButton.png" onClick="changeDisLikeImage()" name="disLikeBtn" class="disLikeBtn" id="disLikeBtn" />
            <?php

            $liked = 0;
            $disliked = 0;
            $likedPercent = 0;
            for ($i = 0; $i < sizeOf($decodedLikeData['ratings']); $i++) {
                if ($decodedLikeData['ratings'][$i]['recipe_id'] == $recipeID) {
                    if ($decodedLikeData['ratings'][$i]['rating'] == "like") {
                        $liked++;
                    } elseif ($decodedLikeData['ratings'][$i]['rating'] == "dislike") {
                        $disliked++;
                    }
                }
            }
            if (($liked + $disliked) != 0) {
                $likedPercent = $liked / ($liked + $disliked);
                echo '<h2>' . $likedPercent . ' % of people liked this recipe</h2>';
            } else {
                $likedPercent = 0;
                echo '<h2> This recipe has not been rated yet </h2>';
            }


            ?>

            <script language="javascript">
                function changeLikeImage() {
                    if (document.getElementById("likeBtn").src.includes('likeButton.png')) {
                        //Checking if the disLiked button is checked and unchecking it
                        if (document.getElementById("disLikeBtn").src.includes('disLikedButton.png')) {
                            document.getElementById("disLikeBtn").src = "images/likeButton.png";
                        }
                        document.getElementById("likeBtn").src = "images/likedButton.png";
                        //Set recipe to liked here using MySQL
                        //curl - d '{"recipe_id" : "'.$recipeID.
                        //'", "user_id" : "9", "rating" : "like"}' - H "Content-Type: application/json" - X POST 'http://localhost:80/api/RateRecipe/create.php';

                    } else {
                        document.getElementById("likeBtn").src = "images/likeButton.png";
                        //Remove like value from database

                    }
                }

                function changeDisLikeImage() {
                    if (document.getElementById("disLikeBtn").src.includes('likeButton.png')) {
                        //Checking if the liked button is checked and unchecking it
                        if (document.getElementById("likeBtn").src.includes('likedButton.png')) {
                            document.getElementById("likeBtn").src = "images/likeButton.png";
                        }
                        document.getElementById("disLikeBtn").src = "images/disLikedButton.png";
                        //Set recipe to disliked here using MySQL
                        //curl - d '{"recipe_id" : "'.$recipeID.
                        //'", "user_id" : "9", "rating" : "dislike"}' - H "Content-Type: application/json" - X POST 'http://localhost:80/api/RateRecipe/create.php';
                    } else {
                        document.getElementById("disLikeBtn").src = "images/likeButton.png";
                        //Remove disLike from database
                    }
                }
            </script>

            <?php

            echo '<h2> Ingredients </h2>';
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

            echo '<h2> User Comments </h2>
                <form action="recipeInfo.php?id=' . $_GET['id'] . '" method="post" id="usrform">
                    <textarea rows="4" cols="50" name="comment" form="usrform" placeholder="Write your comment down here"></textarea>
                    <button type="submit" name="id" value="' . $_GET['id'] . '" onclick="window.location.reload()"> Submit </button>
                </form>';


            $url_post = 'http://52.91.254.222/api/CommentRecipe/create.php';
            $newComment = json_encode(array(
                'user_id' => 4,
                'recipe_id' => 2,
                'comment_text' => $_POST['comment']
            ));

            $options = array(
                'http' => array(
                    'method'  => 'POST',
                    'content' => $newComment,
                    'header' =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n"
                )
            );

            $stream  = stream_context_create($options);
            $result = file_get_contents($url_post, false, $stream);
            $response = json_decode($result);
            //Comment is stored in $_POST['comment'];

            /*
            $newComment = json_encode(array(
                'user_id' => 4,
                'recipe_id' => 2,
                'comment_text' => $_POST['comment']
            ));

            $_POST['comment'] = '';

            $url_post = 'http://52.91.254.222/api/CommentRecipe/create.php';
            $ch = curl_init($url_post);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$newComment);
            curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
            $curl_result = curl_exec($ch);

            */
            //Loop that prints out all comments for current recipe
            for ($i = 0; $i < sizeOf($decodedComments['comments']); $i++) {
                //if($decodedComments['comments'][$i]['recipe_id'] == $recipeID){
                echo '' . $decodedComments['comments'][$i]['user_id'] . ' says: 
                    ' . $decodedComments['comments'][$i]['comment_text'] . '<br>';
                //}
            }

            ?>
        </div>
        <div class="sidelinks">
            <?php
            echo '<h2> You may also like these Recipes</h2>';
            //Generating related links with clickable images
            for ($r = 0; $r < $relatedLinks[$r]; $r++) {
                echo '<div class = "related">
                 <a href=recipeInfo.php?id=' . $relatedLinks[$r]['id'] . '><img class="relatedImg" src="https://spoonacular.com/recipeImages/'
                    . $relatedLinks[$r]['image'] . '" alt="recipeImage" style="width:100%;"></a>
                 <div class="relatedTitle">' . $relatedLinks[$r]['title'] . '</div>
            </div>';
            };;
            ?>
        </div>
    </div>
</body>

</html>
