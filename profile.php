<html>

<title>User profile</title>
<?php
include 'navbar.php';
?>
<style>

  body{
      background-image: url(images/carrots-food-fresh-616404.jpg);
      background-size: 100%;
  }

  .headerText{
    margin-top: 50px;
    text-align: center;
    align: center;
  }

  .userContainerLeft{
    width: 100%;
    text-align: center;
    align: center;
  }

  .userContainerRight{
    width: 100%;
    text-align: left;
    align: center;
  }

  * {
  box-sizing: border-box;
  }

  /* Create two unequal columns that floats next to each other */
  .column {
    float: left;
    padding: 10px;
    align: center;
  }

  .left {
    width: 35%;
    margin-left: 150px;
  }

  .right {
    width: 35%;
  }

  /* Clear floats after the columns */
  .row:after {
    content: "";
    display: table;
    clear: both;
  }

</style>

<div class="headerText">
  <?php
  $request = "http://52.91.254.222/api/User/read.php";
  $cmd = "curl --location --request GET " . $request;
  $output_arr = json_decode(shell_exec($cmd),true);
  $users = $output_arr['users'];
  //still needs a session variable to store the oauth token
  $session_token = "QQQQQ";
  for($i = 0; $i < sizeof($users); $i++){
    $info_array = $users[$i];
    if ($info_array['oauth_token'] == $session_token){
      break;//breaks the loop on the current user.
    }//end if
  }//end for

  echo '<h1>' . $info_array['user_name'] . "'s Profile" . '</h1>';
  //still need user inventory to be stored
  ?>
</div>

<div class="row">
  <div class="column left">
    <div class="userContainerLeft">
      <h2>User's name</h2>
      <h2>User's email</h2>
      <h2>User's inventory</h2>
    </div>
  </div>
  <div class="column right">
    <div class="userContainerRight">
      <h2> Allergies: </h2>
      <h2> This user commented on: </h2>
      <h2> User's liked reipes:  </h2>
    </div>
  </div>
</div>

</html>
