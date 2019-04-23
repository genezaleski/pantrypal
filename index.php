<head>
<meta   name="google-site-verification"
        content="W0LpZ8p6M13ICggYTyUZqikpTXnPCnY-0d_U6uQC5p0" />
</head>

<style>
body{
    background-image: url(images/carrots-food-fresh-616404.jpg);
    background-size: 100%;
}

.row {
  display: flex;
}

.columnLeft {
  flex: 50%;
  margin-left: 200px;
}

.columnRight {
  flex: 50%;
  margin-right: 200px;
}

.indexSearch {
  position: relative;
  text-align: center;
  color: white;
  font-weight: bold;
  font-size: 26px;
  margin-top: 40px;
}

/* Centered text */
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>

<!-- <title>Pantry Pal</title> -->
<?php
include 'navbar.php';
?>

<div class="row">
  <div class="columnLeft">
    <form class="indexSearch" name="inventorySearch" method="post" action="reciperesults.php">
        <input style="display: none;" type="text" name="searchBar" value="Breakfast">
        <input type="image" src="images/breakfast.jpg" name="image" width=300px height=200px>
        <div class="centered" style="pointer-events:none;">Breakfast</div>
    </form>

    <form class="indexSearch" name="inventorySearch" method="post" action="reciperesults.php">
        <input style="display: none;" type="text" name="searchBar" value="Entree">
        <input type="image" src="images/dinner.jpg" name="image" width=300px height=200px>
        <div class="centered" style="pointer-events:none;">Dinner</div>
    </form>
  </div>

  <div class="columnRight">
    <form class="indexSearch" name="inventorySearch" method="post" action="reciperesults.php">
        <input style="display: none;" type="text" name="searchBar" value="Lunch">
        <input type="image" src="images/Lunch.jpg" name="image" width=300px height=200px>
        <div class="centered" style="pointer-events:none;">Lunch</div>
    </form>

    <form class="indexSearch" name="inventorySearch" method="post" action="reciperesults.php">
        <input style="display: none;" type="text" name="searchBar" value="Vegan">
        <input type="image" src="images/vegan.jpg" name="image" width=300px height=200px>
        <div class="centered" style="pointer-events:none;">Vegan</div>
    </form>
  </div>
</div>

</div>

