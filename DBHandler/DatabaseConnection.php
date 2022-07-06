<?php
class DatabaseConnection{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $myDatabase= "workspace";

    public $conn="";
   
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->myDatabase", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo "Connected successfully";
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }   
    }

}
?>