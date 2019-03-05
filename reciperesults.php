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

<h1 class="searchtitle"> Results </h1><br>
