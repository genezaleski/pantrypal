<?php
class Recipe{

    // database connection and table name
    private $conn;
    private $table_name = "Recipe";

    // object properties
    public $recipe_id;
    public $api_name;
    public $api_recipe_id;
    public $title;
    public $author;
    public $recipe_link;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create a new Recipe given api_name, api_recipe_id, title, author, recipe_link
    function create(){
      $query = "INSERT INTO
                  " . $this->table_name . "
              SET api_name=:api_name, api_recipe_id=:api_recipe_id,
              title=:title, author=:author, recipe_link=:recipe_link";

      // prepare query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->api_name=htmlspecialchars(strip_tags($this->api_name));
      $this->api_recipe_id=htmlspecialchars(strip_tags($this->api_recipe_id));
      $this->title=htmlspecialchars(strip_tags($this->title));
      $this->author=htmlspecialchars(strip_tags($this->author));
      $this->recipe_link=htmlspecialchars(strip_tags($this->recipe_link));

      // bind values
      $stmt->bindParam(":api_name", $this->api_name);
      $stmt->bindParam(":api_recipe_id", $this->api_recipe_id);
      $stmt->bindParam(":title", $this->title);
      $stmt->bindParam(":author", $this->author);
      $stmt->bindParam(":recipe_link", $this->recipe_link);

      // execute query
      if($stmt->execute()){
          return true;
      }
      return false;
    }

    // return all recipes in Datbase
    function read(){
        $query = "SELECT
                    recipe_id, api_name, api_recipe_id, title, author, recipe_link
                FROM
                    " . $this->table_name . ";";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    //return a recipe with a given recipe_id
    function readOne(){
      $query = "SELECT
                recipe_id, api_name, api_recipe_id, title, author, recipe_link
            FROM
                " . $this->table_name . "
            WHERE
                recipe_id = ?";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );

      // bind id of product to be updated
      $stmt->bindParam(1, $this->recipe_id);

      // execute query
      $stmt->execute();

      // get retrieved row
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->recipe_id = $row['recipe_id'];
      $this->api_name = $row['api_name'];
      $this->api_recipe_id = $row['api_recipe_id'];
      $this->title = $row['title'];
      $this->author = $row['author'];
      $this->recipe_link = $row['recipe_link'];
    }

    //returns a recipe with a given api_name and api_recipe_id
    function readOneAPI(){
      $query = "SELECT
                recipe_id, api_name, api_recipe_id, title, author, recipe_link
            FROM
                " . $this->table_name . "
            WHERE
                api_name=? AND api_recipe_id=?";

      // prepare query
      $stmt = $this->conn->prepare( $query );

      // bind values
      $stmt->bindParam(1, $this->api_name);
      $stmt->bindParam(2, $this->api_recipe_id);

      // execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set values to object properties
      $this->recipe_id = $row['recipe_id'];
      $this->api_name = $row['api_name'];
      $this->api_recipe_id = $row['api_recipe_id'];
      $this->title = $row['title'];
      $this->author = $row['author'];
      $this->recipe_link = $row['recipe_link'];
    }
}
?>
