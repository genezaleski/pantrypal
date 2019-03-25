<?php/*
include_once 'config.php';
if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
    $profile = $user . "'s Profile";
    } else {
    $profile = "Profile";
}
*/
?>

<style>
.navbox{
    width: 104.3em;
    display: flex;
    margin: 0 auto;
    margin-left: -10px;
    margin-top: -10px;
    margin-right: -10px; 
    padding: 20px;
    background-color: orange;
}
.navbox a{
    margin: 0 auto;
    display: inline;
    margin-left: 5px;
    float: left;
    font-size: 32px;
    color: black;
    padding: 10px 16px;
    text-decoration: none;
    font-family: "Arial";
}

.dropbtn {
  float: right;
  background-color: #4CAF50;
  color: black;
  padding: 10px;
  font-size: 18px;
  border: none;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.drop-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 30px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.drop-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  font-size: 16px;
}

/* Change color of dropdown links on hover */
.drop-content a:hover {background-color: #ddd;}

/* Show the dropdown menu on hover */
.dropdown:hover .drop-content {display: block;}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {background-color: #3e8e41;}

</style>
<div class=navbox>
    <a href="index.php" target=""> Pantry Pal </a>
    <div class= "dropdown" style = "float:right">
        <button class="dropbtn">User Options<i class="fa fa-caret-down"></i></button>
        <div class= "drop-content">
            <a href="profile.php"> My Profile</a>
            <a href="inventory.php"> Inventory </a>
            <a href="index.php"> Logout </a>
        </div>
    </div>
</div>
<br>

