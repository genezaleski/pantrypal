<style>
@font-face{
    font-family: 'results_font';
    src: url(Acme-Regular.ttf);
}

body{
    background-color: grey;
    background-image: url(images/wooden-background-1538068471RLq);
    background-size: 100%;
    margin: 0px;
}

.searchbar{
    margin-left: 675px;
    width: 300px;s
}

.searchtitle{
    margin-left: 550px;
}

.imgresults{
    display: block;
    max-width:420px;
    max-height:236px;
    width: auto;
    height: auto;
    -webkit-filter: grayscale(0%);
    margin-bottom: 15px;
    z-index: 1;
}

.imgresults:hover{
    -webkit-filter: grayscale(100%); 
}

.recipeName{
    position: absolute;
    display: block;
    float: left;
    margin-top: -220px;
    margin-left: 100px;
    margin-right: -300px;
    z-index: 2;
    font-family: 'results_font';
    pointer-events: none;
    font-size: 32px;
    color: white;
    text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
    max-width:250px;
    word-wrap:break-word;
}

.column{
    float: left;
    width: 33.33%;
    padding: 0px;
    margin-left: 100px;
    margin-right: -125px;
}

.row::after{
    content: "";
    clear: both;
    display: table;
}

.nav-side{
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    max-width: 250px;
    background-color: orange;
    z-index: 3;
    box-sizing: border-box;
    padding: 20px;
    margin-left: -250px;
    margin-top: 140px;
}

.nav-side.nav-open{
    margin-left: 0px;
    box-shadow: 1px 1px 3px rgba(0, 0, 0, .1);
}

.nav-side.nav-open .nav-toggle:before{
    content: "\2190";
}

.nav-toggle{
    position: absolute;
    right: -40px;
    top: 0;
    width: 40px;
    height: 40px;
    background-color: orange;
    line-height: 40px;
    text-decoration: none;
    text-align: center;
    border-bottom-right-radius: 3px;
    box-shadow: 1px 0 3px rgba(0,0,0,.1);
}

.nav-toggle:before{
    content: "\2192";
    font-weight: 600;

}
</style>

<title>Search Results:</title>

<?php
include 'navbar.php';
?>

<form name="recipeSearch" method="post" action="reciperesults.php">
    <input class="searchbar" type="text" name="searchBar" placeholder="put ingredients or recipe name here">
    <input type="submit" name="Submit" value="Search">
</form>

<!-- JS for filter slide out menu-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- End JS for filter menu-->

<nav class="nav-side">
    Filters
    <a href="#" class="nav-toggle"></a>
</nav>

<script language="JavaScript">
    $('.nav-side .nav-toggle').on('click',function(e){
        e.preventDefault();
        $(this).parent().toggleClass('nav-open');
    }
    );
</script>


<?php

$search = $_POST['searchBar'];
$image_results = array();
$id = null;
$id_list = array();
$title = null;
$title_list = array();

if(!empty($search)){
    $api_key = '"X-RapidAPI-Key : 87c88962ddmsh12cc4705c3707b2p13794cjsnf4b26acb6bc4"';
    $api_url = null;
    $is_ingredients = strpos($search, ',');
    if($is_ingredients !== false ) { //If commas are in search string, search by ingredients
        $api_url = '"https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/findByIngredients?number=60&ingredients=' . urlencode($search) .'"';

        $cmd = "curl " . $api_url . "  -H " . $api_key;

        $output_arr = json_decode(shell_exec($cmd),true);

        for($i = 0; $i < sizeof($output_arr); $i++){
            $image = $output_arr[$i]['image'];
            $id = $output_arr[$i]['id'];
            $title = $output_arr[$i]['title'];

            array_push($id_list,$id);
            array_push($title_list,$title);
            array_push($image_results,$image);
           //echo '<div class="imageResults">
             //   <a href=recipeInfo.php?id='.$id.'><img src="'. $image .'" alt="recipeImage" style="flex: ' . $width/$height . ';"></a>
              //  <div class="recipeName">"' . $output_arr[$i]['title'] . '"</div>
              //  </div>';

            //echo "<br>";
        }
    }
    else{                                 //If no commas, search by recipe name
        $api_url = '"https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/search?number=60&query=' . urlencode($search) .'"';

        $cmd = "curl " . $api_url . "  -H " . $api_key;

        $output_arr = json_decode(shell_exec($cmd),true);

        //Get the number of results to avoid undefined indexes
        if($output_arr['totalResults'] < $output_arr['number']){
            $num = $output_arr['totalResults'];
        }
        else{
            $num = $output_arr['number'];
        }

        for($i = 0; $i < $num; $i++){
            if($is_ingredients == false){
                $image = "https://spoonacular.com/recipeImages/" . $output_arr['results'][$i]['image'];
                $id = $output_arr['results'][$i]['id'];
                $title = $output_arr['results'][$i]['title'];

                array_push($image_results,$image);
                array_push($id_list,$id);
                array_push($title_list,$title);
               // echo '<div class="imageResults">
               //     <a href=recipeInfo.php?id='.$id.'><img src="'. $image .'" alt="recipeImage" style="width:35%;"></a>
               //     <div class="recipeName">"' . $output_arr['results'][$i]['title'] . '"</div>
               // </div>';

                //echo "<br>";
            }
        }
    }
}

$one = '';
$two = '';
$three = '';

for($i = 0; $i < sizeof($image_results); $i++){
    if(($i % 3) == 1){
        $one .= '<div class="imglink">
                 <a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>
                 <div class="recipeName">' .$title_list[$i]. '</div>
                 </div>';
    }
    else if(($i % 3) == 2){
        $two .= '<div class="imglink">
                 <a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>
                 <div class="recipeName">' .$title_list[$i]. '</div>
                 </div>';
    }
    else if(($i % 3) == 0){
        $three .= '<div class="imglink">
                   <a href=recipeInfo.php?id='.$id_list[$i].'><img class="imgresults" src="'. $image_results[$i] .'" alt="recipeImage" style="width:100%;"></a>
                   <div class="recipeName">' .$title_list[$i]. '</div>
                   </div>';
    }
}

echo '<div class="row">
        <div class="column">
        ' . $one . '
        </div>
        <div class="column">
        ' . $two . '
        </div>
        <div class="column">
        ' . $three . '
        </div>
    </div>';

?> <!--End PHP-->
