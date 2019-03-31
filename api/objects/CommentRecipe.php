<?php
class CommentRecipe{

    // database connection and table name
    private $conn;
    private $table_name = "CommentRecipe";

    // object properties
    public $user_id;
    public $comment_id;
    public $recipe_id;
    public $comment_text;
    public $comment_time;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read
    function read(){

        // select all query
        $query = "SELECT
                    comment_id, user_id, recipe_id,
                    comment_text, comment_time
                FROM
                    " . $this->table_name . ";";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
?>