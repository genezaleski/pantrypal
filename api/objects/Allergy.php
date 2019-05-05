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

    // return all Allergies in database
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

    //return allergies with given user_id
    function readUser(){
      $query = "SELECT
                allergy_item_id, allergy_itemName
            FROM
                " . $this->table_name . "
            WHERE
                user_id = ?";

      $stmt = $this->conn->prepare( $query );

      $stmt->bindParam(1, $this->user_id);

      $stmt->execute();

      return $stmt;
    }

    // create an allergy with an allergy_itemName and user_id
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

    // delete the allergy, requires allergy_itemName and user_id
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . "
                  WHERE allergy_itemName = ? and user_id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind id of record to delete
        $stmt->bindParam(1, $this->allergy_itemName);
        $stmt->bindParam(2, $this->user_id);

        // execute query
        if($stmt->execute() && $stmt->rowCount() > 0){
            return true;
        }

        return false;

    }
}
?>
