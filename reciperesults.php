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

$search = $_POST['searchBar'];

if(!empty($search)){
    $api_key = '"X-RapidAPI-Key : a44d550177msh8aeb1867319b60bp1fbbc5jsn1d9edc60417a"';
    $api_url = null;
    if(strpos($search, ',') !== false ) { //If commas are in search string, search by ingredients
        $api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/findByIngredients?ingredients=" . urlencode($search);
    }
    else{                                 //If no commas, search by recipe name
        $api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/search?query=" . $search;
    }
    

    $cmd = "curl -H " . $api_key . " " . $api_url;

    $output_arr = json_decode(shell_exec($cmd),true);
    


   for($i = 0; $i < 10; $i++){
        print_r($output_arr['results'][$i]['title']."\n");
        echo "<br>";
   }

}
?> <!--End PHP-->

<form name="recipeSearch" method="post" action="reciperesults.php">
    <input class="searchbar" type="text" name="searchBar" placeholder="put ingredients or recipe name here">
    <input type="submit" name="Submit" value="Search">
</form>

<h1 class="searchtitle"> Results </h1><br>


