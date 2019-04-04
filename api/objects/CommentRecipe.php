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
                    comment_time=NOW()";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->recipe_id=htmlspecialchars(strip_tags($this->recipe_id));
        $this->comment_text=htmlspecialchars(strip_tags($this->comment_text));


        // bind values
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":recipe_id", $this->recipe_id);
        $stmt->bindParam(":comment_text", $this->comment_text);
        

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // used when filling up the update comment form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    comment_id, user_id, recipe_id, comment_text, comment_time
                FROM
                    " . $this->table_name . "
                WHERE
                    recipe_id = ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of comment to be updated
        $stmt->bindParam(1, $this->recipe_id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->comment_id = $row['user_id'];
        $this->user_id = $row['user_id'];
        $this->recipe_id = $row['recipe_id'];
        $this->comment_text = $row['comment_text'];
        $this->comment_text = $row['comment_time'];
    }
}
?>