<?php
class PantryItem{

    // database connection and table name
    private $conn;
    private $table_name = "PantryItem";

    // object properties
    public $user_id;
    public $item_name;
    public $pantry_item_id;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read
    function read(){

        // select all query
        $query = "SELECT
                    pantry_item_id, item_name, user_id
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
