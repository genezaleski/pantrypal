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
    width: 65em;
    display: flex;
    border-radius: 25px;
    margin: 0 auto;
    padding: 10px;
    background-color: #40e0d0;
}
.nav {
    margin: 0 auto;
    display: inline;
    overflow: hidden;
    font-family: Arial;
}
.nav a {
    margin:0 auto;
    border-radius: 25px;
    float: left;
    font-size: 16px;
    color: #000;
    background-color: #40e0d0;
    text-align: center;
    padding: 10px 16px;
    text-decoration: none;
}
.nav a:hover, .drop:hover .dropbtn {
    background-color: #31b6a8;
}
</style>
<div class=navbox>
    <div class= nav>
        <a href="index.php" target=""> Home </a>
       
    </div>
    <br>
</div>
