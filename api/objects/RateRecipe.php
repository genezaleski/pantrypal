<?php
class RateRecipe{

    // database connection and table name
    private $conn;
    private $table_name = "RateRecipe";

    // object properties
    public $ratedRecipe_id;
    public $recipe_id;
    public $user_id;
    public $likes;
    public $dislikes;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read
    function read(){

        // select all query
        $query = "SELECT
                    ratedRecipe_id, recipe_id, user_id, rating
                FROM
                    " . $this->table_name . ";";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    function getLikes(){
      $query = "SELECT
            recipe_id, count(ratedRecipe_id) as likes
          FROM
            ". $this->table_name . "
            where rating = 'like' and recipe_id=?";




      $stmt = $this->conn->prepare($query);

      // bind id of product to be updated
      $stmt->bindParam(1, $this->recipe_id);



      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->recipe_id = $row['recipe_id'];
      $this->likes = $row['likes'];




    }

    // create
    function create(){

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                recipe_id=:recipe_id, user_id=:user_id, rating=:rating";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->recipe_id=htmlspecialchars(strip_tags($this->recipe_id));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->rating=htmlspecialchars(strip_tags($this->rating));

        // bind values
        $stmt->bindParam(":recipe_id", $this->recipe_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":rating", $this->rating);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>
