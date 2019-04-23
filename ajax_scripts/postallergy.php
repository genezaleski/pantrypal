<?php
postAllergy();

function postAllergy(){
    $url_post = 'http://52.91.254.222/api/Allergy/create.php';
    $allergy = json_encode(array(
            "allergy_itemName"=> $_POST['allergy'],
            "user_id"=> $_POST['id']
    ));


    $options = array(
        'http' => array(
            'method' => 'POST',
            'content' => $allergy,
            'header' => "Content-Type: application/json\r\n"."Accept: application/json\r\n"
        )
    );

    $stream = stream_context_create($options);
    $result = file_get_contents($url_post,false,$stream);
    $response = json_decode($result);

}
?>

