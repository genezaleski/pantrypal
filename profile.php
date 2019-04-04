<html>

<title>User profile</title>
<?php
include 'navbar.php';
?>
<style>
  .usercontainer{
    width: 75%;
    background-color: #ffffff;
    text-align: center;
    align: center;
  }

</style>

<div class="usercontainer">
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
echo '<h1>' . "Hello " . $info_array['user_name'] . '</h1>';
echo '<h2>' . "User's email" . '</h2>';
//still need user email to be stored
echo '<h2>' . "User's inventory" . '</h2>';
//still need user inventory to be stored

?>
</div>

</html>
