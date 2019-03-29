<?php
class user{
 
    // database connection and table name
    private $conn;
    private $table_name = "User";
 
    // object properties
    //public $user_id;
    public $user_name;
    public $oauth_token;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read users
    function read(){

        // select all query
        $query = "SELECT
                    user_id, user_name, oauth_token
                FROM
                    " . $this->table_name .";";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create user
    function create(){
 
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    oauth_token=:oauth_token, user_name=:user_name";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->oauth_token=htmlspecialchars(strip_tags($this->oauth_token));
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
    
        // bind values
        $stmt->bindParam(":oauth_token", $this->oauth_token);
        $stmt->bindParam(":user_name", $this->user_name);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
 
        return false;
    }
}
?>
