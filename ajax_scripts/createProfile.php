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

$email = $_POST['user'];
$token = $_POST['id'];
$name = $_SESSION['name'];
$image = $_POST['imageurl'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$random = rand(0, 99999999999999999999999);
$randomString = window.btoa($random);

//searchByName();
createProfile();
function createProfile(){
            $url_post = "http://52.91.254.222/api/User/create.php";
            $createUser = json_encode(array(
                'user_name' => $_POST['user'],
                'oauth_token' => $randomString,
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
            
            //$stream = stream_context_create($options);
            //$result = file_get_contents($url_post,false,$stream);
            //$response = json_decode($result);
                        //$url_post = 'http://52.91.254.222/api/CommentRecipe/create.php';
                        $ch = curl_init($url_post);
                        curl_setopt($ch,CURLOPT_POST,1);
                        curl_setopt($ch,CURLOPT_POSTFIELDS,$createUser);
                        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
                        $curl_result = curl_exec($ch);
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
