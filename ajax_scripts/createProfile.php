<?php
createProfile();
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
}
?>