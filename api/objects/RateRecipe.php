<?php
class RateRecipe{

    // database connection and table name
    private $conn;
    private $table_name = "RateRecipe";

    // object properties
    public $ratedRecipe_id
    public $recipe_id
    public $user_id
    public $rating
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read
    function read(){

        // select all query
        $query = "SELECT
                    ratedRecipe_id, recipe_id, user_id,
                    rating
                FROM
                    " . $this->table_name . ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
?>
