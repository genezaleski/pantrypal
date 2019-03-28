<style>
body{
    background-color: grey;
    background-size: 100%;
}


.imageResults{
    position: relative;
    text-align: center;
    color: white;
}

.recipeName{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>

<title>Search Results:</title>

<?php
include 'navbar.php';
?>

<?php

    $api_key = '"X-RapidAPI-Key : 87c88962ddmsh12cc4705c3707b2p13794cjsnf4b26acb6bc4"';
    $api_url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/random?number=10";

        $cmd = "curl -H " . $api_key . " " . $api_url;

        $output_arr = json_decode(shell_exec($cmd),true);

        for($i = 0; $i < sizeof($output_arr); $i++){
            $image = $output_arr[$i]['image'];
            $id = $output_arr[$i]['id'];

            echo '<div class="imageResults">
                <a href="recipeInfo.php?id="' . $id . '" ><img src="'. $image .'" alt="recipeImage" style="width:35%;"></a>
                <div class="recipeName">"' . $output_arr[$i]['title'] . '"</div>
                </div>';

            echo "<br>";
        }
?> <!--End PHP-->

