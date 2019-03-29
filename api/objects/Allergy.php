<?php
class Allergy{

    // database connection and table name
    private $conn;
    private $table_name = "Allergy";

    // object properties
    public $allergy_item_id;
    public $allergy_itemName;
    public $user_id;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read
    function read(){

        // select all query
        $query = "SELECT
                    allery_item_id, allergy_itemName, user_id
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
