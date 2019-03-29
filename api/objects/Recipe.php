<?php
class Recipe{

    // database connection and table name
    private $conn;
    private $table_name = "Recipe";

    // object properties
    public $recipe_id;
    public $api_name;
    public $api_recipe_id;
    public $title;
    public $recipe_link;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read users
    function read(){

        // select all query
        $query = "SELECT
                    recipe_id, api_name, api_recipe_id, title, recipe_link
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
