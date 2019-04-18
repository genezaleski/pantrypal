<?php
searchByName();
function createProfile(){
            $url_post = 'http://52.91.254.222/api/User/create.php';
            $createUser = json_encode(array(
                'user_name' => $_POST['user'],
                'oauth_token' => $_POST['id']
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

}//end searchByName
?>
