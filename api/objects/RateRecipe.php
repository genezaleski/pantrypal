<?php
class RateRecipe{

    // database connection and table name
    private $conn;
    private $table_name = "RateRecipe";

    // object properties
    public $ratedRecipe_id;
    public $recipe_id;
    public $user_id;
    public $rating;

    public $likes; //count
    public $dislikes; //count

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

    function getLikesUser(){
      $query = "SELECT recipe_id
                from RateRecipe
                where rating = 'like' and user_id = ?";

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->user_id);
      $stmt->execute();

      return $stmt;
    }

    function getLikes(){
      //join two values into a table
      $query = "SELECT * FROM
                (SELECT recipe_id, count(ratedRecipe_id) as likes
                FROM ". $this->table_name ."
                WHERE rating = 'like' and recipe_id=?) A
                CROSS JOIN
                (SELECT count(ratedRecipe_id) as dislikes
                FROM ". $this->table_name ."
                WHERE rating = 'dislike' and recipe_id=?) B";




      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->recipe_id);
      $stmt->bindParam(2, $this->recipe_id);


      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->recipe_id = $row['recipe_id'];
      $this->likes = $row['likes'];
      $this->dislikes = $row['dislikes'];
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

    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . "
                  WHERE recipe_id = ? and user_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind id of record to delete
        $stmt->bindParam(1, $this->recipe_id);
        $stmt->bindParam(2, $this->user_id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    function updateLikes(){

      //query to update likes
      $query = "UPDATE " . $this->table_name ."
                SET
                  rating = ?
                WHERE user_id = ? AND recipe_id = ?";

      $stmt = $this->conn->prepare($query);


      $stmt->bindParam(1, $this->rating);
      $stmt->bindParam(2, $this->user_id);
      $stmt->bindParam(3, $this->recipe_id);

      // execute query
      if($stmt->execute()){
        return true;
      }
      return false;
    }
}
?>
