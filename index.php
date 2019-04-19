<link rel="stylesheet" type="text/css" href="stylesheets/resultspagestyle.css">
<head>
<meta   name="google-site-verification"
        content="W0LpZ8p6M13ICggYTyUZqikpTXnPCnY-0d_U6uQC5p0" />
</head>

<style>
body{
    background-image: url(images/carrots-food-fresh-616404.jpg);
    background-size: 100%;
}
.searchtitle{
    margin-left: 500px;
    margin-top: 50px;
    margin-bottom: -300px;
    padding: 0px;
}
.searchbar{
    margin-left: 500px;
    margin-top: 300px;
    width: 300px;
}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  margin-top: 30px;
  margin-left: 370px;
  margin-right: 370px;
  text-align: center;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  background-color: inherit;
  float: center;
  display: inline;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 16px;
  font-weight: bold;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
  background-color: #ccc;
  margin-left: 100px;
  margin-right: 100px;
}
</style>

<!-- <title>Pantry Pal</title> -->
<?php
include 'navbar.php';
?>

<!-- Tab links -->
<div class="tab">
  <button class="tablinks active" onclick="openTabs(event, 'Recommended')">Recommended</button>
  <button class="tablinks" onclick="openTabs(event, 'Breakfast')">Breakfast</button>
  <button class="tablinks" onclick="openTabs(event, 'Lunch')">Lunch</button>
  <button class="tablinks" onclick="openTabs(event, 'Dinner')">Dinner</button>
  <button class="tablinks" onclick="openTabs(event, 'Vegan')">Vegan</button>
</div>

<!-- Tab content -->
  <h1><center>
  <?php
  $api_key = "'X-RapidAPI-Key : d466494462msh9686e88c15be8cfp108f2ejsnbc67ad6ec517'";
  $api_url = "'https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/food/jokes/random'";
  $cmd = "curl " . $api_url . "  -H " . $api_key;
  $output_arr = json_decode(shell_exec($cmd),true);
  $results = $output_arr['text'];
  echo $results;
  ?>
</center></h1>
<div id="Recommended" class="tabcontent" style="display:block">
  <h3>Recommended</h3>
  <p>Recommended Recipes Go Here.</p>
</div>

<div id="Breakfast" class="tabcontent">
  <h3>Breakfast</h3>
  <p>Breakfast Recipes Go Here.</p>
</div>

<div id="Lunch" class="tabcontent">
  <h3>Lunch</h3>
  <p>Lunch Recipes Go Here.</p>
</div>

<div id="Dinner" class="tabcontent">
  <h3>Dinner</h3>
  <p>Dinner Recipes Go Here.</p>
</div>

<div id="Vegan" class="tabcontent">
  <h3>Vegan</h3>
  <?php

  $isveggie ='';
  if(isset($_POST['Vegetarian'])){
      $isveggie = $isveggie . "diet=vegetarian&";
  }

  $image_results = array();
  $id = null;
  $id_list = array();
  $title = null;
  $title_list = array();

  $api_key = "'X-RapidAPI-Key : d466494462msh9686e88c15be8cfp108f2ejsnbc67ad6ec517'";
  $api_url = "'https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/random?number=12&tags=vegetarian%2Cvegan'";
  $api_host = "'X-RapidAPI-Host: spoonacular-recipe-food-nutrition-v1.p.rapidapi.com'";
  $cmd = "curl " . $api_url . "  -H " . $api_key;
  $output_arr = json_decode(shell_exec($cmd),true);
  $results = $output_arr['recipes'];
  $output_arr = $results;

  for($i = 0; $i < sizeof($output_arr); $i++){
      $image = $output_arr[$i]['image'];
      $id = $output_arr[$i]['id'];
      $title = $output_arr[$i]['title'];

      array_push($id_list,$id);
      array_push($title_list,$title);
      array_push($image_results,$image);
  }

  $one = '';
  $two = '';
  $three = '';

  //Puts images into columns
  for($i = 0; $i < sizeof($image_results); $i++){
      if(($i % 3) == 1){
          $one .= '<div class="imglink">
                   <a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>
                   <div class="recipeName">' .$title_list[$i]. '</div>
                   </div>';
      }
      else if(($i % 3) == 2){
          $two .= '<div class="imglink">
                   <a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>
                   <div class="recipeName">' .$title_list[$i]. '</div>
                   </div>';
      }
      else if(($i % 3) == 0){
          $three .= '<div class="imglink">
                     <a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>
                     <div class="recipeName">' .$title_list[$i]. '</div>
                     </div>';
      }
  }

  echo '<div class="row">
          <div class="column">
          ' . $one . '
          </div>
          <div class="column">
          ' . $two . '
          </div>
          <div class="column">
          ' . $three . '
          </div>
      </div>';
  ?>
</div>

<script>
function openTabs(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
