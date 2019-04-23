<html>
<link rel="stylesheet" type="text/css" href="stylesheets/profileStyle.css">

<script language="javascript">//scripts to add and remove allergies
    function postAllergy(addAllergy,userID){
        var xmlhtml = new XMLHttpRequest();
        xmlhtml.open('POST','ajax_scripts/postAllergy.php',true);
        xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        if(xmlhtml.readyState == 4 && xmlhtml.status == 200) {
            alert(xmlhtml.responseText);
	    }
        xmlhtml.send("allergy="+addAllergy+"&id="+userID);
    }

    function removeAllergy(oldAllergy,userID){
        var xmlhtml = new XMLHttpRequest();
        xmlhtml.open('POST','ajax_scripts/removeAllergy.php',true);
        xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        if(xmlhtml.readyState == 4 && xmlhtml.status == 200) {
            alert(xmlhtml.responseText);
	    }
        xmlhtml.send("allergy="+oldAllergy+"&id="+userID);
    }
</script>

<title>User profile</title>
<?php
include 'navbar.php';
?>


<div class="headerText">
  <?php

  echo '<h1>' . $_SESSION['email'] . "'s Profile" . '</h1>';

  //print_r($_SESSION);

?>
</div>

<div class="row">
  <div class="column left">
    <div class="userContainerLeft">
    <?php
      echo '<h2> Name: ' . $_SESSION['name'] . '</h2>';
      ?>
      <h2> Allergies: </h2>
        
      <form action="profile.php" method="post" id="usrform" class="newAllergyBox">
        <input class="AllergyAddBox" type="text" name="AllergyAdd" placeholder="Input new item...">
        <button class="AllergyAddButton" type="submit" id="ajaxButton" name="commentClick" value="TRUE" onClick="postAllergy(this.form.AllergyAdd.value,<?php echo $_SESSION['user_id'];?>)"> Add </button>
    </form>

    <form action="profile.php" method="post" id="usrform" class="removeAllergyBox">
        <input class="AllergyRemoveBox" type="text" name="AllergyRemove" placeholder="Input item to be removed...">
        <button class="AllergyRemoveButton" type="submit" id="ajaxButton2" name="commentClick2" value="TRUE" onClick="removeAllergy(this.form.AllergyRemove.value,<?php echo $_SESSION['user_id'];?>)"> Remove </button>
    </form>

<?php
  $userID = $_SESSION['user_id'];
  $request = "http://52.91.254.222/api/Allergy/read.php";
  $cmd = "curl --location --request GET " . $request;
  $allergies = json_decode(shell_exec($cmd),true);
  for($i = 0; $i < sizeof($allergies); $i++){
    echo $allergies[$i];
  }
  $j = 1;
  $allergiesPost = '';


  if(!(isset($allergies['Allergy']))){
    echo '<p class="yourallergies"> Congratulations on your superior genetics. You have no allergies. </p>';
  }
  else{
    for($i = 0; $i < sizeof($allergies['Allergy']);$i++){
      if($allergies['Allergy'][$i]['user_id'] == $userID){
        $name =  $allergies['Allergy'][$i]['allergy_itemName'];
        echo $name . "  ";
        echo "     ";
        if(($j % 5) == 0){
          echo "<br>";
        }
        $j++;
        
      }
    }
  }
?>

<h2> Your Comments: </h2>
      <?php 
      //Retriving user comments
      $commentCmd= 'curl "http://52.91.254.222/api/CommentRecipe/profile_page.php?user_id=' . $_SESSION['user_id'] .'"';
      $uComJSON = json_decode(shell_exec($commentCmd), true);
      //print_r($uComJSON);
      for($i = 0; $i < sizeof($uComJSON['comments']); $i++){
        //echo $uComJSON['comments'][$i];
        $rId = $uComJSON['comments'][$i]['recipe_id'];
        $com = $uComJSON['comments'][$i]['comment_text'];
        echo "You commented " . $com . " on recipe number " . $rId;
        echo '<br>';
      }

      ?>


      
    </div>
  </div>
  <div class="column right">
    <div class="userContainerRight">
      <?php
      echo '<h2> Email: ' . $_SESSION['email'] . '</h2>';
      echo '<h2> Inventory: </h2>';
      
      $inventoryCmd = "curl http://52.91.254.222/api/PantryItem/read.php";
      $decodedInventory = json_decode(shell_exec($inventoryCmd), true);
      $j = 1;
      $ingredientsPost = '';

      //This loop both displays the inventory of the user
      //and populates the ingredientsPost variable to be 
      //used for a search by ingredients based off the user's
      //inventory.
      if(!(isset($decodedInventory['PantryItem']))){
        echo '<p class="urInventory"> Your pantry is empty. </p>';
      }
      else{
        for($i = 0; $i < sizeof($decodedInventory['PantryItem']);$i++){
            if($decodedInventory['PantryItem'][$i]['user_id'] == $userID){
              $name =  $decodedInventory['PantryItem'][$i]['item_name'];
              echo $name . " ";
              if(($j % 5) == 0){
                echo "<br>";
              }
              $j++;
            }
          }
        }
      ?>
      

      
      <h2> Your liked recipes:  </h2>
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
           if($i == $randy){
             $chosenID = $titleJSON['api_recipe_id'];
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
         echo '<a href=recipeInfo.php?id=' . $relatedRec[$randy2]['id'] . '><button> Recomended </button></a>';
      ?>
    </div>
  </div>
</div>

</html>
