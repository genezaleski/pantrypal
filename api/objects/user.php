<?php
class User{

    // database connection and table name
    private $conn;
    private $table_name = "User";

    // object properties
    public $user_id;
    public $oauth_token;
    public $user_name;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read
    function read(){

        // select all query
        $query = "SELECT
                    user_id, oauth_token, user_name
                FROM
                    " . $this->table_name . ;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

}
?>
