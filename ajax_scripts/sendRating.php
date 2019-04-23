<?php
sendRating();

function sendRating()
{
    $recID = $_POST['rID'];
    $uID = $_POST['user'];
    $rating = $_POST['rate'];

    //Retriving like data for a specific recipe
    $recLiked = 'curl "http://52.91.254.222/api/RateRecipe/read_one.php?recipe_id=' . $recID . '&user_id=' . $uID . '"';
    $likeData = json_decode(shell_exec($recLiked), true);

    if ($likeData{'recipe_id'} != $recID) {
        $url_post = 'http://52.91.254.222/api/RateRecipe/create.php';
        $newLike = json_encode(array(
            'recipe_id' => $recID,
            'user_id' => $uID,
            'rating' => $rating
        ));
    
    
        $options = array(
            'http' => array(
                'method' => 'POST',
                'content' => $newLike,
                'header' => "Content-Type: application/json\r\n" . "Accept: application/json\r\n"
            )
        );
    
        $stream = stream_context_create($options);
        $result = file_get_contents($url_post, false, $stream);
        $response = json_decode($result);
    } else {
        $update = 'curl "http://52.91.254.222/api/RateRecipe/update.php?recipe_id='.$recID.'&user_id='.$uID.'&rating='.$rating.'"';
        shell_exec($update);
    }
    
}
