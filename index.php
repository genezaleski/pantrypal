<head>
<meta   name="google-site-verification" 
        content="W0LpZ8p6M13ICggYTyUZqikpTXnPCnY-0d_U6uQC5p0" />
</head>

<style>
body{
    background-image: url(images/carrots-food-fresh-616404.jpg);
    background-size: 100%;
}

.searchbar{
    margin-left: 675px;
    margin-top: 300px;
    width: 300px;
}

.searchtitle{
    margin-left: 675px;
    margin-top: 300px;
    margin-bottom: -300px;
    padding: 0px;
}
</style>

<title>Pantry Pal</title>
<?php
include 'navbar.php';

?>
<h1 class="searchtitle"> Pantry Pal </h1><br>
<form name="recipeSearch" method="post" action="reciperesults.php">
    <input class="searchbar" type="text" name="searchBar" placeholder="put ingredients or recipe name here">
    <input type="submit" name="Submit" value="Search">
</form>

