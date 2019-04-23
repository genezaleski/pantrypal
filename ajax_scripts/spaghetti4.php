<?php
  session_start();

  $user = $_POST['email'];
  //$url = "'52.91.254.222/api/User/read_one.php'";
  //$cmd = "curl " . $url . "?user_name=" . $user;
  $cmd = 'curl "http://52.91.254.222/api/User/read_one.php?user_name='.$user.'"';
  //echo $cmd;
  $output_arr = json_decode(shell_exec($cmd),true);
  $id = $output_arr['user_id'];
  //echo $id;
  $_SESSION['user_id'] = $id;
  
  
  ?>
