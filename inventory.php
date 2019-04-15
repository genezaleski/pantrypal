<?php
include 'navbar.php';

//Here is where the code would go to access the user's UID
//harcoded atm due to no login

//Access list of registered users
$accountCmd = "curl http://52.91.254.222/api/User/read.php";
$decodedAccounts = json_decode(shell_exec($accountCmd), true);

//print_r($decodedAccounts);

echo '<p> Hello, '. $decodedAccounts['users'][1]['user_name'] .'</p>';
echo '<br>';
echo '<p> Here are your inventory items: </p>';

//Access user inventory
$inventoryCmd = "curl http://52.91.254.222/api/User/read.php";
$decodedInventory = json_decode(shell_exec($inventoryCmd), true);

?>
