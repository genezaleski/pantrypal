<?php
session_start();
/*
//clears any previous session data
unset($_SESSION['email']);
unset($_SESSION['token']);
unset($_SESSION['name']);
unset($_SESSION['image']);
unset($_SESSION['firstName']);
unset($_SESSION['lastName']);

//fills session variable with useful profile information
$_SESSION['email'] = $_POST['user'];
$_SESSION['token'] = $_POST['id'];
$_SESSION['name'] = $_POST['name'];
$_SESSION['image'] = $_POST['imageUrl'];
$_SESSION['firstName'] = $_POST['firstName'];
$_SESSION['lastName'] = $_POST['lastName'];
*/

$email = $_SESSION['email'];
$token = $_SESSION['token'];
$name = $_SESSION['name'];
$image = $_SESSION['image'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];

//searchByName();
createprofile();
function createProfile(){
            $url_post = 'http://52.91.254.222/api/User/create.php';
            $createUser = json_encode(array(
                'oauth_token' => $_POST['id'],
                'user_name' => $_POST['user'],
                'first_name' => $_POST['firstName'],
                'last_name' => $_POST['lastName'],
                'picture_path' => $_POST['imageurl']
                
            ));
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'content' => $createUser,
                    'header' => "Content-Type: application/json\r\n"."Accept: application/json\r\n"
                )
            );
            $stream = stream_context_create($options);
            $result = file_get_contents($url_post,false,$stream);
            $response = json_decode($result);
}//end createProfile
/*
//checks to see if username already exists in the database
function searchByName(){
    $searchUser = $_POST['user'];
    $request = "http://52.91.254.222/api/User/read_one.php?user_name=" . $searchUser;
    $cmd = "curl --location --request GET " . $request;
    $output_arr = json_decode(shell_exec($cmd),true);
    //this will be returned if the user exists
    $result = $output_arr['user_name'];

    if ($result !== $searchUser){
        //adds the user to the database
        createProfile();
    }//

}//end searchByName*/
?>
