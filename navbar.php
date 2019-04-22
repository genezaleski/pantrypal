
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
  margin-top: 7px;
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

.searchbarNav{
    margin-top: 20px;
    width: 300px;
}

.navSearch{
  margin-right: 300px;
}

//all pages that load navbar can now use session variables
<?php
session_start();
?>

</style>
<div class=navbox>
    <a href="index.php" target=""> Pantry Pal </a>
    <form class="navSearch" name="recipeSearch" method="post" action="reciperesults.php">
        <input class="searchbarNav" type="text" name="searchBar" placeholder="Put Ingredients or Recipe Name Here">
        <input type="submit" name="Submit" value="Search">
    </form>
    <div class= "dropdown" style = "float:right">
        <button class="dropbtn">User Options<i class="fa fa-caret-down"></i></button>
        <br>
        <br>
        <div class= "drop-content">
        <html lang="en">
        <head>
          <meta name="google-signin-scope" content="profile email">
          <meta name="google-signin-client_id" content="818469007806-1oi7h6015kjsggbd4m0i6j4ro9dq6vqt.apps.googleusercontent.com">
          <script src="https://apis.google.com/js/platform.js" async defer></script>
          <script  src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
              
              //truncates email to remove everything after the '@'
              var email = profile.getEmail();
              var emailLength = email.search("@");
              email = email.substring(0,emailLength);
              var name = profile.getName();
              var profileImage = profile.getImageUrl();
              var firstName = profile.getGivenName();
              var lastName = profile.getFamilyName();

              //checks if user exists in the database and
              //creates them if they dont

              sendPart1(email, id_token);
              sendPart2(name, profileImage);
              sendPart3(firstName, lastName);
              sendProfile(email, id_token, name, profileImage, firstName, lastName);
              //function to create the user
              function sendProfile(email, token, name, profileImage, firstName, lastName){
                    var xmlhtml = new XMLHttpRequest();
                    var xmlhtml2 = new XMLHttpRequest();
                    var length = token.length;
                    console.log(length);
                    var encoded64 = window.btoa(token.substring(0,127));
                    console.log(encoded64);
                    xmlhtml.open('POST','ajax_scripts/createProfile.php',true);
                    xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhtml.send("user="+email+"&id="+encoded64);
                }//end sendprofile

                function sendPart1(email, token){
                    var xmlhtml = new XMLHttpRequest();
                    var length = token.length;
                    console.log(length);
                    var encoded64 = window.btoa(token.substring(0,127));
                    console.log(encoded64);
                    xmlhtml.open('POST','ajax_scripts/spaghetti1.php',true);
                    xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhtml.send("user="+email+"&id="+encoded64);
                    //xmlhtml.send("name="name+"&imageUrl="profileImage);
                    //xmlhtml.send("firstName="firstName+"&lastName="lastName);
                }//end sendPart1

                function sendPart2(name, profileImage){
                    var xmlhtml = new XMLHttpRequest();
                    xmlhtml.open('POST','ajax_scripts/spaghetti2.php',true);
                    xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhtml.send("name="+name+"&imageUrl="+profileImage);
                }//end sendPart2

                function sendPart3(firstName, lastName){
                    var xmlhtml = new XMLHttpRequest();
                    xmlhtml.open('POST','ajax_scripts/spaghetti3.php',true);
                    xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xmlhtml.send("firstName="+firstName+"&lastName="+lastName);
                }//end sendPart3

            }//end onSignIn
          </script>
        </body>
      </html>
            <a href="profile.php"> My Profile</a>
            <a href="inventory.php"> Inventory </a>
            <a href="devs.php">Developers</a>
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            <meta name="google-signin-client_id" content="818469007806-1oi7h6015kjsggbd4m0i6j4ro9dq6vqt.apps.googleusercontent.com">
            <a href="#" onclick="signOut();">Sign out</a>
            <?php
            session_destroy();
            ?>
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
