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
                    allergy_item_id, allergy_itemName, user_id
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
                allergy_itemName=:allergy_itemName, user_id=:user_id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->allergy_itemName=htmlspecialchars(strip_tags($this->allergy_itemName));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind values
        $stmt->bindParam(":allergy_itemName", $this->allergy_itemName);
        $stmt->bindParam(":user_id", $this->user_id);        

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>