<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="stylesheets/recipeInfoStyle.css">

<?php
include 'navbar.php';
$recipeID = $_GET['id'];

//Redirect to home if there is no recipe ID
if ($recipeID == ""){
    alert("This recipe is not working correctly, redirecting to home");
    echo '<script type="text/javascript">
             window.location = "index.php"
        </script>';
  }
  function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
  }

$my_api_key = '"X-RapidAPI-Key :322dc0a550msh6970a9bebfd18b2p1010fcjsnaed4930a9684"';
$other_api_key = '"X-RapidAPI-Key : 4af690163bmshda5b867e43cbc70p155394jsnc38cedc3355a"';
$third_api_key = '"X-RapidAPI-Key : a44d550177msh8aeb1867319b60bp1fbbc5jsn1d9edc60417a"';

//Retrieving recipe info
$api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $recipeID . "/information";
$cmd = "curl -H " . $my_api_key . " " . $api_url;
$recipeInfo = json_decode(shell_exec($cmd), true);

//Retriving similar recipies to add as links
$related_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $recipeID . "/similar";
$relatedCmd = "curl -H " . $other_api_key . " " . $related_url;
$relatedLinks = json_decode(shell_exec($relatedCmd), true);

//Get nutritional information for recipes
$nutrition_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/".$recipeID."/nutritionWidget.json";
$nutrition_cmd = "curl -H " . $third_api_key . " " . $nutrition_url;
$nutritionalInfo = json_decode(shell_exec($nutrition_cmd), true);

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

//Checking for if a user had previously liked/disliked a recipe
$checkRatingCmd = 'curl "http://52.91.254.222/api/RateRecipe/checkRating.php?user_id=' . $_SESSION['user_id'] . '&recipe_id=' . $DB_ID .'"';
$checkRating = json_decode(shell_exec($checkRatingCmd), true);

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

            //Initializing like images
            $initLikeImg = "images/likeButton.png";
            $initDislikeImg = "images/likeButton.png";
            //If user has previously rated the recipe and setting to the correct image
            if($checkRating['rating'] == "like"){
                $initLikeImg = "images/likedButton.png";
            }else if($checkRating['rating'] == "dislike"){
                $initDislikeImg = "images/disLikedButton.png";
            }

            ?>
            <!-- Like/Dislike Buttons -->
            <input type="image" alt="" src=<?php echo $initLikeImg; ?> onClick="changeLikeImage()" name="likeBtn" class="likeBtn" id="likeBtn" />
            <input type="image" alt="" src=<?php echo $initDislikeImg; ?> onClick="changeDisLikeImage()" name="disLikeBtn" class="disLikeBtn" id="disLikeBtn" />
            <?php
            
            $totalRatings = $decodedRatings['likes'] + $decodedRatings['dislikes'];
            if (($totalRatings) != 0) {
                $likePercent = ($decodedRatings['likes'] / $totalRatings) * 100;
                echo '<h2>' . $likePercent . ' % of people liked this recipe</h2>';
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
                        deleteRating(<?php echo $DB_ID; ?>);
                        sendRating(<?php echo $DB_ID; ?>, "like");
                    } else {
                        document.getElementById("likeBtn").src = "images/likeButton.png";
                        //Remove like value from database
                        deleteRating(<?php echo $DB_ID; ?>);
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
                        deleteRating(<?php echo $DB_ID; ?>);
                        sendRating(<?php echo $DB_ID; ?>, "dislike");
                    } else {
                        document.getElementById("disLikeBtn").src = "images/likeButton.png";
                        //Remove disLike from database
                        deleteRating(<?php echo $DB_ID; ?>);
                    }
                }
                //Sends the like/dislike to database
                function sendRating(dbID, rating) {
                    if(userName != ""){
                    var xmlhtml = new XMLHttpRequest();
                    var userID = <?php echo $_SESSION['user_id'];?>;
                    xmlhtml.open('POST', 'ajax_scripts/sendRating.php', true);
                    xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhtml.send("user=" + userID + "&rID=" + dbID + "&rate=" + rating);
                    }else{
                        alert("Your rating will not be counted unless you are logged in");
                    }
                }
                //Removes a rating from the database
                function deleteRating(dbID) {
                    var xmlhtml = new XMLHttpRequest();
                    var userID = <?php echo $_SESSION['user_id'];?>;
                    xmlhtml.open('POST', 'ajax_scripts/deleteRating.php', true);
                    xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhtml.send("user=" + userID + "&rID=" + dbID);
                }
                //Sends comments to the database
                function postComment(phpComment, dbID) {
                    if (userName != "") {
                        var userID = <?php echo $_SESSION['user_id'];?>;
                        //document.write(userID);
                        var xmlhtml = new XMLHttpRequest();
                        xmlhtml.open('POST', 'ajax_scripts/postComment.php', true);
                        xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xmlhtml.send("comment=" + phpComment + "&item=" + dbID + "&UID=" + userID);
                    } else {
                        alert("Please sign in to post a comment")
                    }
                }
            </script>

            <?php
            //printing nutritional info
            echo '<h2> Nutrition Facts </h2>';
            echo "Calories: " . $nutritionalInfo['calories'] . "<br>";
            echo "Carbohydrates: " . $nutritionalInfo['carbs'] . "<br>";
            echo "Fat: " . $nutritionalInfo['fat'] . "<br>";
            echo "Protein: " . $nutritionalInfo['protein'] . "<br>";
            echo "Sugar: " . $nutritionalInfo['bad'][4]['amount'] . "<br>";
            echo "Sodium: " . $nutritionalInfo['bad'][6]['amount'] . "<br>";
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
            ?>

            <h2> User Comments </h2>
            <form action="recipeInfo.php?id=<?php echo $_GET['id'] ?>" method="post" id="usrform">
                <textarea rows="4" cols="50" name="comment" form="usrform" placeholder="Write your comment down here"></textarea>
                <button type="submit" id="ajaxButton" name="commentClick" value="TRUE" onClick="postComment(this.form.comment.value,<?php echo $DB_ID; ?>)"> Submit </button>
            </form>

            <?php
            //Loop that prints out all comments for current recipe
            for ($i = 0; $i < sizeOf($decodedComments['comments']); $i++) {
                $commentorID = $decodedComments['comments'][$i]['user_id'];
                $commentorNameURL = 'curl "http://52.91.254.222/api/User/read_name.php?user_id='.$commentorID.'"';
                $decodedCommentorName = json_decode(shell_exec($commentorNameURL), true);;
                if ($decodedComments['comments'][$i]['recipe_id'] == $DB_ID) {
                    echo '<div class="comment-user-name">' . $decodedCommentorName['user_name']. ' says</div>
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


