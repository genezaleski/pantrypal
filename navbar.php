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
    padding: 20px;
    background-color: orange;
}
.nav {
    margin: 0 auto;
    display: inline;
    margin-left: 0px;
}
.nav a {
    margin:0 auto;
    float: right;
    font-size: 32px;
    color: white;
    padding: 10px 16px;
    text-decoration: none;
    font-family: "Arial";
}
.nav a:hover, .drop:hover .dropbtn {
    background-color: #31b6a8;
}
</style>
<div class=navbox>
    <div class= nav>
        <a href="index.php" target=""> Pantry Pal </a>      
    </div>
    <br>
</div>

