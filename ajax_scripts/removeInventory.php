<?php
removeInventory();

function removeInventory(){
    $item_name = $_POST['item'];
    $user_id = $_POST['id'];
    //$url_post = 'http://52.91.254.222/api/PantryItem/delete.php?item_name='.$item_name.'&user_id='.$user_id.'';
    $inventoryRemoveCmd = 'curl "http://52.91.254.222/api/PantryItem/delete.php?item_name='.urlencode($item_name).'&user_id='.$user_id.'"';    
    $decodedInventory = json_decode(shell_exec($inventoryRemoveCmd), true);
}
?>


