<link rel="stylesheet" type="text/css" href="stylesheets/inventoryStyle.css">
<script language="javascript">
    function postInventory(newItem,userID){
        //document.write("New item, user id" + newItem + userId);
        var xmlhtml = new XMLHttpRequest();
        xmlhtml.open('POST','ajax_scripts/postInventory.php',true);
        xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        if(xmlhtml.readyState == 4 && xmlhtml.status == 200) {
            alert(xmlhtml.responseText);
	    }
        xmlhtml.send("item="+newItem+"&id="+userID);
    }

    function removeInventory(oldItem,userID){
        //document.write("New item, user id" + newItem + userId);
        var xmlhtml = new XMLHttpRequest();
        xmlhtml.open('POST','ajax_scripts/removeInventory.php',true);
        xmlhtml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        if(xmlhtml.readyState == 4 && xmlhtml.status == 200) {
            alert(xmlhtml.responseText);
	    }
        xmlhtml.send("item="+oldItem+"&id="+userID);
    }
</script>
<?php
include 'navbar.php';

$userID = $_SESSION['user_id'];
$userName = $_SESSION['email'];

//Access list of registered users
$accountCmd = 'curl "http://52.91.254.222/api/User/read_one.php?user_name=' . $userName.'"';
$decodedAccounts = json_decode(shell_exec($accountCmd), true);

echo '<p class="dispUsername"> Hello, '. $decodedAccounts['user_name'] .'</p>';
echo '<p class="urInventory"> Your Inventory: </p>';

//Get user id for retrieving + posting inventory items
?>
    <form action="inventory.php" method="post" id="usrform" class="newItemBox">
        <input class="inventoryAddBox" type="text" name="inventoryAdd" placeholder="Input new item...">
        <button class="inventoryAddButton" type="submit" id="ajaxButton" name="commentClick" value="TRUE" onClick="postInventory(this.form.inventoryAdd.value,<?php echo $userID;?>)"> Add </button>
    </form>

    <form action="inventory.php" method="post" id="usrform" class="removeItemBox">
        <input class="inventoryAddBox" type="text" name="inventoryRemove" placeholder="Input item to be removed...">
        <button class="inventoryAddButton" type="submit" id="ajaxButton2" name="commentClick2" value="TRUE" onClick="removeInventory(this.form.inventoryRemove.value,<?php echo $userID;?>)"> Remove </button>
    </form>

<?php
echo '<br>';

//Access user inventory
//$inventoryCmd = "curl http://52.91.254.222/api/PantryItem/read_one.php?user_id=" . $userID . "";
$inventoryCmd = "curl http://52.91.254.222/api/PantryItem/read.php";
$decodedInventory = json_decode(shell_exec($inventoryCmd), true);
$j = 1;
$ingredientsPost = '';

//This loop both displays the inventory of the user
//and populates the ingredientsPost variable to be 
//used for a search by ingredients based off the user's
//inventory.
if(!(isset($decodedInventory['PantryItem']))){
    echo '<br>';
    echo '<p class="urInventory"> Your pantry is empty. </p>';
    echo '<br>';
}
else{
    for($i = 0; $i < sizeof($decodedInventory['PantryItem']);$i++){
        if($decodedInventory['PantryItem'][$i]['user_id'] == $userID){
            $name =  $decodedInventory['PantryItem'][$i]['item_name'];
            echo "<p class='info'>" . $name . "</p>";
            echo "     ";
            if(($j % 5) == 0){
                echo "<br>";
            }
            $j++;
    
            //populate ingredientsPost
            //doesn't add duplicate ingredients
            if(strpos($ingredientsPost,$name) == false){
                $ingredientsPost = $ingredientsPost . $name . ",";
            }
        }
    }
}

echo '<br>';


?>

<form class="navSearch" name="inventorySearch" method="post" action="reciperesults.php">
    <input style="display: none;" type="text" name="searchBar" value="<?php echo $ingredientsPost;?>">
    <input class="inventoryAddButton2" type="submit" name="Submit" value="Find recipes from my Pantry">
</form>



