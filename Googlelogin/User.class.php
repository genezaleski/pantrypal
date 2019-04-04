<?php

class User {
	private $dbHost     = DB_HOST;
    private $dbUsername = DB_USERNAME;
    private $dbPassword = DB_PASSWORD;
    private $dbName     = DB_NAME;
    private $userTbl    = DB_USER_TBL;
	
	function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
	
	function checkUser($userData = array()){
        if(!empty($userData)){
            // Check whether user data already exists in the database
            $checkQuery = "SELECT * FROM ".$this->userTbl." WHERE oauth_uid = '".$userData['oauth_uid']."'";
            $checkResult = $this->db->query($checkQuery);
            if($checkResult->num_rows > 0){
                // Update user data if already exists
                $query = "UPDATE ".$this->userTbl." SET first_name = '".$userData['first_name']."', 
                last_name = '".$userData['last_name']."', 
                picture = '".$userData['picture']."', 
                modified = NOW() WHERE oauth_uid = '".$userData['oauth_uid']."'";
                $update = $this->db->query($query);
            }else{
                // Insert user data in the database
                $query = "INSERT INTO ".$this->userTbl." SET oauth_uid = '".$userData['oauth_uid']."', 
                first_name = '".$userData['first_name']."', 
                last_name = '".$userData['last_name']."',  
                picture = '".$userData['picture']."',
                modified = NOW()";
                $insert = $this->db->query($query);
            }
            
            // Get user data from the database
            $result = $this->db->query($checkQuery);
            $userData = $result->fetch_assoc();
        }
        
        // Return user data
        return $userData;
    }
}