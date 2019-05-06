<?php
class User{

    // database connection and table name
    private $conn;
    private $table_name = "User";

    // object properties
    public $user_id;
    public $oauth_token;
    public $user_name;
    public $first_name;
    public $last_name;
    public $picture_path;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create user with given user_name, oauth_token, first_name, last_name, picture_path
    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    user_name=:user_name, oauth_token=:oauth_token,
                    first_name=:first_name, last_name=:last_name,
                    picture_path=:picture_path";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->user_name=htmlspecialchars(strip_tags($this->user_name));
        $this->oauth_token=htmlspecialchars(strip_tags($this->oauth_token));
        $this->fist_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->picture_path=htmlspecialchars(strip_tags($this->picture_path));

        // bind values
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":oauth_token", $this->oauth_token);
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":picture_path", $this->picture_path);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete a user with given user_id
    function delete(){

      // delete query
      $query = "DELETE FROM " . $this->table_name . "
                WHERE user_id = ?";

      // prepare query
      $stmt = $this->conn->prepare($query);

      // bind id of record to delete
      $stmt->bindParam(1, $this->user_id);

      // execute query
      if($stmt->execute() && $stmt->rowCount() > 0){
          return true;
      }
    }

    // return all Users in database
    function read(){

        // select all query
        $query = "SELECT
                    user_id, user_name, first_name, last_name, picture_path
                FROM
                    " . $this->table_name . ";";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // return a User with given user_name
    function readOne(){
        $query = "SELECT *
            FROM
                " . $this->table_name . "
              WHERE
                  user_name = ?";

                  // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->user_name);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->user_id = $row['user_id'];
        $this->oauth_token = $row['oauth_token'];
        $this->user_name = $row['user_name'];
      }

      // returns a user with given user_id
    function readTwo(){
        // query to read single record
        $query = "SELECT *
            FROM
                " . $this->table_name . "
              WHERE
                  user_id= ?";

                  // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->user_id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->user_id = $row['user_id'];
        $this->oauth_token = $row['oauth_token'];
        $this->user_name = $row['user_name'];
      }
}
?>
