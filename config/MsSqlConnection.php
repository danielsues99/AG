<?php

class MsSQLConnection{
    private $host = "localhost";
    private $user = "admin";
    private $password = "admin1234";
    private $db = "ar_schema";
    private $charset = "utf8";

   public function OpenConnection(){
       try{
        $connection = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($connection, $this->user, $this->password, $options);
        
        return $pdo;
       }catch(PDOException $e){
           echo 'Error in connection: '.$e->getMessage();
           exit;
       }
   }

}

?>