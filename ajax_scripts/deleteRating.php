<?php
deleteRating();

function deleteRating(){
    $url_post = 'http://52.91.254.222/api/RateRecipe/delete.php';
    $dRating = json_encode(array(
            'recipe_id' => $_POST['rID'],
            'user_id' => $_POST['user']
    ));


    $options = array(
        'http' => array(
            'method' => 'POST',
            'content' => $dRating,
            'header' => "Content-Type: application/json\r\n"."Accept: application/json\r\n"
        )
    );

    $stream = stream_context_create($options);
    $result = file_get_contents($url_post,false,$stream);
    $response = json_decode($result);
}
?>