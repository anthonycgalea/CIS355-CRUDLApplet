<?php
class Database{
   
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "id16522165_projects";
    private $username = "id16522165_admin";
    private $password = "?D=oXL\iT5_#r/1M";
    public $conn;
   
    // get the database connection
    public function getConnection(){
   
        $this->conn = null;
   
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
   
        return $this->conn;
    }
}
?>