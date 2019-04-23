<html>
<link rel="stylesheet" type="text/css" href="stylesheets/profileStyle.css">

<title>User profile</title>
<?php
include 'navbar.php';
?>

<div class="headerText">
  <?php
  $request = "http://52.91.254.222/api/User/read.php";
  $cmd = "curl --location --request GET " . $request;
  $output_arr = json_decode(shell_exec($cmd),true);
  $users = $output_arr['users'];
  //still needs a session variable to store the oauth token
  $session_token = $_SESSION['token'];
  for($i = 0; $i < sizeof($users); $i++){
    $info_array = $users[$i];
    if ($info_array['oauth_token'] == $session_token){
      break;//breaks the loop on the current user.
    }//end if
  }//end for

  echo '<h1>' . $_SESSION['email'] . "'s Profile" . '</h1>';
  //still need user inventory to be stored

  echo '<h1>' . $_SESSION['name'] . '</h1>';
  print_r($_SESSION);
  ?>
</div>

<div class="row">
  <div class="column left">
    <div class="userContainerLeft">
    <?php
      echo '<h2> Name: ' . $_SESSION['name'] . '</h2>';
      echo '<h2> Email: ' . $_SESSION['email'] . '</h2>';
      echo '<h2> View Inventory </h2>';
    ?>
    </div>
  </div>
  <div class="column right">
    <div class="userContainerRight">
      <h2> Allergies: </h2>
      <h2> This user commented on: </h2>
      <?php 
      //Retriving user comments
      $commentCmd= 'curl "http://52.91.254.222/api/CommentRecipe/profile_page.php?user_id=' . $_SESSION['user_id'] .'"';
      $uComJSON = json_decode(shell_exec($commentCmd), true);

      for($i = 0; $i < sizeof($uComJSON['comments']); $i++){
        $rId = $uComJSON['comments'][$i]['recipe_id'];
        $com = $uComJSON['comments'][$i]['comment_text'];
        echo "You commented " . $com . " on recipe number " . $rId . "<br>";
      }
      ?>
      <h2> User's liked recipes:  </h2>
      <?php 
      //Retriving user comments
      $likesCmd= 'curl "http://52.91.254.222/api/RateRecipe/liked.php?user_id=' . $_SESSION['user_id'] .'"';
      $uLikeJSON = json_decode(shell_exec($likesCmd), true);

      //Generating a random number under number of likes
      $randy = rand(0, sizeof($uLikeJSON));
      $chosenID;
      for($i = 0; $i < sizeof($uLikeJSON); $i++){
        $rId = $uLikeJSON[$i]['recipe_id'];
        $titleCmd = 'curl "http://52.91.254.222/api/Recipe/read_one.php?recipe_id=' . $rId . '"';
        $titleJSON = json_decode(shell_exec($titleCmd), true);
        if($i = $randy){
          $chosenID = $titleJSON['ap_recipe_id'];
        }
        echo '<div class = "likedRecipeLinks">
          <a href =recipeInfo.php?id='. $titleJSON['api_recipe_id'] .'>' . $titleJSON['title'] . '</a>
          </div>';
      }

      $api_key = '"X-RapidAPI-Key : a44d550177msh8aeb1867319b60bp1fbbc5jsn1d9edc60417a"';

      $recomended = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $chosenID . "/similar";
      $recCmd = "curl -H " . $api_key . " " . $recomended;
      $relatedRec = json_decode(shell_exec($recCmd), true);
      $randy2 = rand(0, sizeof($relatedRec));
      echo '<button href=recipeInfo.php?id=' . $relatedRec[$randy2]['id'] . '>';
      ?>
    </div>
  </div>
</div>

</html>
