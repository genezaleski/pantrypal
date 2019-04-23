<?php
removeAllergy();

function removeAllergy(){
    $allergy_name = $_POST['allergy'];
    $user_id = $_POST['id'];
    $allergyRemoveCmd = 'curl "http://52.91.254.222/api/Allergy/delete.php?allergy_itemName='.$allergy_name.'&user_id='.$user_id.'"';    
    $decodedallergy = json_decode(shell_exec($allergyRemoveCmd), true);
}
?>


