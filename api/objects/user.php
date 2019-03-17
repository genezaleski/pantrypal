<?php
class user {
 
    // database connection and table name
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $user_id;
    public $userName;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){

        // select all query
        $query = "SELECT
                    user_id, userName
                FROM
                    " . $this->table_name . "";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    
    // create product
    function create(){

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    userName=:userName";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->userName=htmlspecialchars(strip_tags($this->userName));

        // bind values
        $stmt->bindParam(":userName", $this->userName);

        // execute query
        if($stmt->execute()){
            return true;
	}

        return false;
    }
}
