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

// if not coming from new search
if(!isset($_POST['searchBar'])){
    header("Location:index.php");
}
$search_sql="SELECT * FROM stock WHERE name LIKE '%".$_POST['searchBar']."%' OR description LIKE '%".$_POST['searchBar']."%'";
$search_query=mysql_query($search_sql);
if(mysql_num_rows($search_query) != 0){
    $search_rs=mysql_fetch_assoc($search_query);
}
?>

<form name="recipeSearch" method="post" action="reciperesults.php">
    <input class="searchbar" type="text" name="searchBar" placeholder="put ingredients or recipe name here">
    <input type="submit" name="Submit" value="Search">
</form>

<h1 class="searchtitle"> Results </h1><br>

