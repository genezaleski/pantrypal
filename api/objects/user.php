<?php
class User{

    // database connection and table name
    private $conn;
    private $table_name = "User";
<<<<<<< Updated upstream
 
    // object properties
    //public $user_id;
    public $user_name;
    public $oauth_token;
 
=======

    // object properties
    public $user_id;
    publi $oauth_token;
    public $user_name;

>>>>>>> Stashed changes
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

<<<<<<< Updated upstream
    // read users
=======
    // read
>>>>>>> Stashed changes
    function read(){

        // select all query
        $query = "SELECT
<<<<<<< Updated upstream
                    user_id, user_name, oauth_token
=======
                    user_id, oauth_token, user_name
>>>>>>> Stashed changes
                FROM
                    " . $this->table_name .";";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

<<<<<<< Updated upstream
    // create user
    function create(){
 
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user_name=:user_name, oauth_token=:oauth_token";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
        $this->oauth_token=htmlspecialchars(strip_tags($this->oauth_token));
    
        // bind values
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":oauth_token", $this->oauth_token);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
 
        return false;
    }
=======
>>>>>>> Stashed changes
}
?>
