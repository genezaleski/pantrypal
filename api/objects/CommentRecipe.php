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

    // create
    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user_id=:user_id, recipe_id=:recipe_id, comment_text=:comment_text, 
                    comment_time=:comment_time";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->recipe_id=htmlspecialchars(strip_tags($this->recipe_id));
        $this->comment_text=htmlspecialchars(strip_tags($this->comment_text));
        $this->comment_time=htmlspecialchars(strip_tags($this->comment_time));


        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":recipe_id", $this->recipe_id);
        $stmt->bindParam(":comment_text", $this->comment_text);
        $stmt->bindParam(":comment_time", $this->comment_time);
        

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>