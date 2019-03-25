<style>
body{
    background-color: grey;
    background-size: 100%;
    margin: 0px;
}

.searchbar{
    margin-left: 675px;
    width: 300px;
}

.searchtitle{
    margin-left: 550px;
}

.imgresults{
    display: block;
    max-width:420px;
    max-height:236px;
    width: auto;
    height: auto;
}

.recipeName{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.column{
    float: left;
    width: 33.33%;
    padding: 0px;
    margin-left: 100px;
    margin-right: -125px;
}

.row::after{
    content: "";
    clear: both;
    display: table;
}
</style>

<title>Search Results:</title>

<?php
include 'navbar.php';
?>

<form name="recipeSearch" method="post" action="reciperesults.php">
    <input class="searchbar" type="text" name="searchBar" placeholder="put ingredients or recipe name here">
    <input type="submit" name="Submit" value="Search">
</form>

<?php

$search = $_POST['searchBar'];
$image_results = array();
$id = null;
$id_list = array();

if(!empty($search)){
    $api_key = '"X-RapidAPI-Key : a44d550177msh8aeb1867319b60bp1fbbc5jsn1d9edc60417a"';
    $api_url = null;
    $is_ingredients = strpos($search, ',');
    if($is_ingredients !== false ) { //If commas are in search string, search by ingredients
        $api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/findByIngredients?ingredients=" . urlencode($search);

        $cmd = "curl -H " . $api_key . " " . $api_url;

        $output_arr = json_decode(shell_exec($cmd),true);

        for($i = 0; $i < sizeof($output_arr); $i++){
            $image = $output_arr[$i]['image'];
            $id = $output_arr[$i]['id'];

            array_push($image_results,$image);
            array_push($id_list,$id);
           //echo '<div class="imageResults">
             //   <a href=recipeInfo.php?id='.$id.'><img src="'. $image .'" alt="recipeImage" style="flex: ' . $width/$height . ';"></a>
              //  <div class="recipeName">"' . $output_arr[$i]['title'] . '"</div>
              //  </div>';

            //echo "<br>";
        }
    }
    else{                                 //If no commas, search by recipe name
        $api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/search?query=" . $search;

        $cmd = "curl -H " . $api_key . " " . $api_url;

        $output_arr = json_decode(shell_exec($cmd),true);

        for($i = 0; $i < $output_arr['number']; $i++){
            if($is_ingredients == false){
                $image = "https://spoonacular.com/recipeImages/" . $output_arr['results'][$i]['image'];
                $id = $output_arr['results'][$i]['id'];

                array_push($image_results,$image);
                array_push($id_list,$id);
               // echo '<div class="imageResults">
               //     <a href=recipeInfo.php?id='.$id.'><img src="'. $image .'" alt="recipeImage" style="width:35%;"></a>
               //     <div class="recipeName">"' . $output_arr['results'][$i]['title'] . '"</div>
               // </div>';

                //echo "<br>";
            }
        }
    }
}

$one = '';
$two = '';
$three = '';

for($i = 0; $i < sizeof($image_results); $i++){
    if(($i % 3) == 1){
        $one .= '<a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>';
    }
    else if(($i % 3) == 2){
        $two .= '<a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>';
    }
    else if(($i % 3) == 0){
        $three .= '<a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>';
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

?> <!--End PHP-->

