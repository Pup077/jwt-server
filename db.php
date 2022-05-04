<?php
class DB_Connection
{

    private $db_host     = "localhost"; //change to your  host
    private $db_name     = "angular-jwt";//change to your db
    private $db_username = "root"; //change to your db username
    private $db_password = ""; //enter your password

    private $conn;

    public function db_connect(){

        $this->conn = null;

        try
        {
            $this->conn = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_username, $this->db_password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        }
        catch(PDOException $e){
            echo "Error " . $e->getMessage();
        }

        return $this->conn;
    }
}
