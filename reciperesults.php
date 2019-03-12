<style>
body{
    background-image: url(images/art-background-citrus-1415734);
    background-size: 100%;
}

.searchbar{
    margin-left: 675px;
    width: 300px;
}

.searchtitle{
    margin-left: 550px;
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
                
            echo '<img src="'.$image.'">';
            echo "<a href=#>'". $output_arr[$i]['title'] ."'</a>";

            echo "<br>";
        }
    }
    else{                                 //If no commas, search by recipe name
        $api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/search?query=" . $search;

        $cmd = "curl -H " . $api_key . " " . $api_url;

        $output_arr = json_decode(shell_exec($cmd),true);

        for($i = 0; $i < $output_arr['number']; $i++){
            if($is_ingredients == false){
                $image = "https://spoonacular.com/recipeImages/" . $output_arr['results'][$i]['image'];
                
                echo '<img src="'.$image.'">';
                echo "<a href=#>'". $output_arr['results'][$i]['title'] ."'</a>";

                echo "<br>";
            }
        }
    }
}
?> <!--End PHP-->


