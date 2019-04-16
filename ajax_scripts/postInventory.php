<?php
postInventory();

function postInventory(){
    $url_post = 'http://52.91.254.222/api/PantryItem/create.php';
    $newComment = json_encode(array(
            "item_name"=> $_POST['item'],
            "user_id"=> $_POST['id']
    ));


    $options = array(
        'http' => array(
            'method' => 'POST',
            'content' => $newComment,
            'header' => "Content-Type: application/json\r\n"."Accept: application/json\r\n"
        )
    );

    $stream = stream_context_create($options);
    $result = file_get_contents($url_post,false,$stream);
    $response = json_decode($result);

    // ---- Old posting method ----
    //$url_post = 'http://52.91.254.222/api/CommentRecipe/create.php';
    //$ch = curl_init($url_post);
    //curl_setopt($ch,CURLOPT_POST,1);
    //curl_setopt($ch,CURLOPT_POSTFIELDS,$newComment);
    //curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
    //$curl_result = curl_exec($ch);
}
?>

