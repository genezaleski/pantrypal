<?php
class PantryItem{

    // database connection and table name
    private $conn;
    private $table_name = "PantryItem";

    // object properties
    public $pantry_item_id;
    public $item_name;
    public $user_id;



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
                    " . $this->table_name . ";";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function delete(){
      $query = "DELETE FROM " . $this->table_name . "
                WHERE item_name = ? and user_id = ?";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->item_name);
      $stmt->bindParam(2, $this->user_id);

      if($stmt->execute() && $stmt->rowCount() > 0){
        return true;
      }

      return false;
    }

    function readOne(){
      $query = "SELECT
                  pantry_item_id, item_name
                FROM
                    " . $this->table_name . "
                    WHERE user_id = ?";

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->user_id);
      $stmt->execute();
      return $stmt;
    }

    // create
    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    item_name=:item_name, user_id=:user_id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->item_name=htmlspecialchars(strip_tags($this->item_name));
        $this->user_id=htmlspecialchars(strip_tags($this->user_id));

        // bind values
        $stmt->bindParam(":item_name", $this->item_name);
        $stmt->bindParam(":user_id", $this->user_id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
?>
