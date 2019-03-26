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
    width: 98.5%;
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
        <br>
        <br>
        <div class= "drop-content">
        <html lang="en">
        <head>
          <meta name="google-signin-scope" content="profile email">
          <meta name="google-signin-client_id" content="680756671435-l6dn77keu8bklio80u87s62l2df19qo5.apps.googleusercontent.com">
          <script src="https://apis.google.com/js/platform.js" async defer></script>
        </head>
        <body>
          <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
          <script>
            function onSignIn(googleUser) {
              // Useful data for your client-side scripts:
              var profile = googleUser.getBasicProfile();
              console.log("ID: " + profile.getId()); // Don't send this directly to your server!
              console.log('Full Name: ' + profile.getName());
              console.log('Given Name: ' + profile.getGivenName());
              console.log('Family Name: ' + profile.getFamilyName());
              console.log("Image URL: " + profile.getImageUrl());
              console.log("Email: " + profile.getEmail());

              // The ID token you need to pass to your backend:
              var id_token = googleUser.getAuthResponse().id_token;
              console.log("ID Token: " + id_token);
            }
          </script>
        </body>
      </html>
            <a href="profile.php"> My Profile</a>
            <a href="inventory.php"> Inventory </a>
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <meta name="google-signin-client_id" content="680756671435-l6dn77keu8bklio80u87s62l2df19qo5.apps.googleusercontent.com">
            <a href="#" onclick="signOut();">Sign out</a>
              <script>
                function signOut() {
                  var auth2 = gapi.auth2.getAuthInstance();
                  auth2.signOut().then(function () {
                    console.log('User signed out.');
                });
                }
                </script>
        </div>
    </div>
</div>
<br>

