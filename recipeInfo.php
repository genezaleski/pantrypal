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

//Pulling in likes and dislikes to be used 
$likeDataCmd = "curl http://52.91.254.222/api/RateRecipe/read.php";
$decodedLikeData = json_decode(shell_exec($likeDataCmd), true);

//Pulling in comments
$commentCmd = "curl http://52.91.254.222/api/CommentRecipe/read.php";
$decodedComments = json_decode(shell_exec($commentCmd), true);

//Pulling in recipes to check if the current one exists
$recipeCmd = "curl http://52.91.254.222/api/Recipe/read.php";
$rListDecode = json_decode(shell_exec($recipeCmd), true);

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

//Retrieve db recipe id
$dbIdCmd = 'curl "http://52.91.254.222/api/Recipe/read_one.php?api_name=spoon&api_recipe_id=' . $recipeID . '"';
$decodedID = json_decode(shell_exec($dbIdCmd), true);
$DB_ID = $decodedID['recipe_id'];

//Retriving like data for a specific recipe
$ratingCmd = 'curl "http://52.91.254.222/api/RateRecipe/likes.php?recipe_id=' . $DB_ID . '"';
$decodedRatings = json_decode(shell_exec($ratingCmd), true);

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
            $totalRatings = $decodedRatings['likes'] + $decodedRatings['dislikes'];
            if (($totalRatings) != 0) {
                $likePercent = ($decodedRatings['likes'] / $totalRatings) * 100;
                echo '<h2>' . number_format($likePercent, 1) . ' % of people liked this recipe</h2>';
            } else {
                echo '<h2> This recipe has not been rated yet </h2>';
            }
            ?>

            <script language="javascript">
                var userName = "<?php echo $_SESSION['email']; ?>";

                function changeLikeImage() {
                    if (document.getElementById("likeBtn").src.includes('likeButton.png')) {
                        //Checking if the disLiked button is checked and unchecking it
                        if (document.getElementById("disLikeBtn").src.includes('disLikedButton.png')) {
                            document.getElementById("disLikeBtn").src = "images/likeButton.png";
                        }
                        document.getElementById("likeBtn").src = "images/likedButton.png";
                        //Set recipe to liked here
                        sendRating(<?php echo $DB_ID; ?>, "like");
                    } else {
                        document.getElementById("likeBtn").src = "images/likeButton.png";
                    }
                }

                function changeDisLikeImage() {
                    if (document.getElementById("disLikeBtn").src.includes('likeButton.png')) {
                        //Checking if the liked button is checked and unchecking it
                        if (document.getElementById("likeBtn").src.includes('likedButton.png')) {
                            document.getElementById("likeBtn").src = "images/likeButton.png";
                        }
                        document.getElementById("disLikeBtn").src = "images/disLikedButton.png";
                        //Set recipe to disliked here
                        sendRating(<?php echo $DB_ID; ?>, "dislike");
                    } else {
                        document.getElementById("disLikeBtn").src = "images/likeButton.png";
                    }
                }
                //Sends the like/dislike to database
                function sendRating(dbID, rating) {
                    if(userName != ""){
                    var xmlhtml = new XMLHttpRequest();
                    xmlhtml.open('POST', 'ajax_scripts/sendRating.php', true);
                    xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhtml.send("user=1&rID=" + dbID + "&rate=" + rating);
                    }else{
                        alert("Your rating will not be counted unless you are logged in");
                    }
                }
                //Removes a rating from the database
                function deleteRating(dbID) {
                    var xmlhtml = new XMLHttpRequest();
                    xmlhtml.open('POST', 'ajax_scripts/deleteRating.php', true);
                    xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhtml.send("user=1&rID=" + dbID);
                }
                //Sends comments to the database
                function postComment(phpComment, dbID) {
                    if (userName != "") {
                        var xmlhtml = new XMLHttpRequest();
                        xmlhtml.open('POST', 'ajax_scripts/postComment.php', true);
                        xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xmlhtml.send("comment=" + phpComment + "&item=" + dbID);
                    } else {
                        alert("Please sign in to post a comment")
                    }
                }
            </script>

            <?php
            echo '<h2> Ingredients </h2>';
            //Loop that generates a list of the ingredients used
            for ($i = 0; $i < $recipeInfo['extendedIngredients'][$i]; $i++) {
                $amount = number_format($recipeInfo['extendedIngredients'][$i]['amount'], 1);
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

            <h2> User Comments </h2>
            <form action="recipeInfo.php?id=<?php echo $_GET['id'] ?>" method="post" id="usrform">
                <textarea rows="4" cols="50" name="comment" form="usrform" placeholder="Write your comment down here"></textarea>
                <button type="submit" id="ajaxButton" name="commentClick" value="TRUE" onClick="postComment(this.form.comment.value,<?php echo $DB_ID; ?>)"> Submit </button>
            </form>

            <?php
            $url_post = 'http://52.91.254.222/api/CommentRecipe/create.php';

            //Loop that prints out all comments for current recipe
            for ($i = 0; $i < sizeOf($decodedComments['comments']); $i++) {
                if ($decodedComments['comments'][$i]['recipe_id'] == $DB_ID) {
                    echo '<div class="comment-user-name">' . $decodedComments['comments'][$i]['user_id'] . ' says</div>
                    <div class="vjs-comment-list">' . $decodedComments['comments'][$i]['comment_text'] . '</div><br>';
                }
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