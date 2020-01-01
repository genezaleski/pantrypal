<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="stylesheets/resultspagestyle.css">
<title>Search Results:</title>

<?php
include 'navbar.php';
?>

<!-- JS for filter slide out menu-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- End JS for filter menu-->

<form name="filters" method="post" action="reciperesults.php">
<nav class="nav-side">
    <p class="filters">Filters</p>
    <a href="#" class="nav-toggle"></a>
    <label class="container"> Vegetarian
        <input type="checkbox" value="TRUE" name="Vegetarian">
        <span class="checkmark"></span>
    </label>
    <label class="container"> Allergies
        <input type="checkbox" value="TRUE" name="Allergies">
        <span class="checkmark"></span>
    </label>
    <label class="container"> Main Courses
        <input type="checkbox" value="TRUE" name="mainCourse">
        <span class="checkmark"></span>
    </label>
    <label class="container"> Appetizers
        <input type="checkbox" value="TRUE" name="Appetizer">
        <span class="checkmark"></span>
    </label>
    <button type="submit" name="searchBar" value="<?php echo $_POST['searchBar']?>" href="reciperesults.php" onclick="window.location.reload()"> Apply </button>
</nav>
</form>

<script language="JavaScript">
    $('.nav-side .nav-toggle').on('click',function(e){
        e.preventDefault();
        $(this).parent().toggleClass('nav-open');
    }
    );
</script>


<?php

//Here we set variables which determine what filters to apply to search

$search = $_POST['searchBar'];

$isveggie ='';
$course='';
$allergies='';

if(isset($_POST['Vegetarian'])){
    $isveggie = $isveggie . "diet=vegetarian&";
}
if(isset($_SESSION)){
    $getAllergies = 'curl "http://52.91.254.222/api/Allergy/userAllergy.php?user_id='.$_SESSION['user_id'].'"';
    $decodedAllergies = json_decode(shell_exec($getAllergies), true);
    if(!(array_key_exists('message',$decodedAllergies))){
        $allergies = $allergies . "&excludeIngredients=";
        for($i = 0; $i < sizeof($decodedAllergies); $i++){
            $allergies = $allergies . $decodedAllergies['Allergy'][$i]['allergy_itemName'] .",";
        }
    }
    urlencode($allergies);
}
if(isset($_POST['mainCourse'])){
    $course = $course . "type=main+course&";
}
else if(isset($_POST['Appetizer'])){
    $course = $course . "type=appetizer&";
}

$image_results = array();
$id = null;
$id_list = array();
$title = null;
$title_list = array();

//Search functionality if query was entered, otherwise gets random recipes
if(!empty($search)){
    $api_key = '"X-RapidAPI-Key : 87c88962ddmsh12cc4705c3707b2p13794cjsnf4b26acb6bc4"';
    $api_url = null;
    $is_ingredients = strpos($search, ',');
    if($is_ingredients !== false ) { //If commas are in search string, search by ingredients
        //$api_url = '"https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/findByIngredients?number=60&ingredients=' . urlencode($search) .'"';
        $api_url = '"https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/searchComplex?'.$isveggie.'includeIngredients="'.urlencode($search).$allergies.'"&'.$course.'ranking=2&limitLicense=true&offset=0&number=60"';

        $cmd = "curl -H " . $api_key . " " . $api_url;
        //$cmd2 = "curl " . $api_url1 . "  -H " . $api_key;

        $output_arr = json_decode(shell_exec($cmd),true);

        if($output_arr['totalResults'] < $output_arr['number']){
            $num = $output_arr['totalResults'];
        }
        else{
            $num = $output_arr['number'];
        }

	//pushes results into array so they can be printed in proper results page format
        for($i = 0; $i < $output_arr['number']; $i++){
            $image = $output_arr['results'][$i]['image'];
            $id = $output_arr['results'][$i]['id'];
            $title = $output_arr['results'][$i]['title'];

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
    $api_url = '"https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/search?'.$isveggie.$allergies.'&number=60&'.$course.'query=' . urlencode($search) .'"';
    //$api_url = '"https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/searchComplex?query="'.urlencode($search).'"&'.$isveggie.$course.'ranking=2&limitLicense=true&offset=0&number=60"';

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
                //$image = $output_arr['results'][$i]['image'];
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
else{//search field is empty. Returns a random recipe

$api_key = "redacted";
$api_url = "'https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/random?number=60'";
$api_host = "'X-RapidAPI-Host: spoonacular-recipe-food-nutrition-v1.p.rapidapi.com'";
$cmd = "curl " . $api_url . "  -H " . $api_key;
$output_arr = json_decode(shell_exec($cmd),true);
$results = $output_arr['recipes'];
$output_arr = $results;

for($i = 0; $i < sizeof($output_arr); $i++){
    $image = $output_arr[$i]['image'];
    $id = $output_arr[$i]['id'];
    $title = $output_arr[$i]['title'];

    array_push($id_list,$id);
    array_push($title_list,$title);
    array_push($image_results,$image);
}//end for
}//end else

$one = '';
$two = '';
$three = '';

//Puts images into columns
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

//places images into columns to be properly styled.
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



