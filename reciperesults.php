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

$api_key = "'X-RapidAPI-Key : a44d550177msh8aeb1867319b60bp1fbbc5jsn1d9edc60417a'";
$api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/random?number=10";

$cmd = "curl -H " . $api_key . " " . $api_url;

$output = shell_exec($cmd);

echo $output;

?>

<form name="recipeSearch" method="post" action="reciperesults.php">
    <input class="searchbar" type="text" name="searchBar" placeholder="put ingredients or recipe name here">
    <input type="submit" name="Submit" value="Search">
</form>

<h1 class="searchtitle"> Results </h1><br>


