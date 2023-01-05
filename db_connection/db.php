<?php

class Db
{
    private $servername;
    private $dbname;
    private $password;
    private $port;
    private $username;

    public function connect()
    {   

        $this->servername = "ourdb.cbvpejuaz9mq.us-east-2.rds.amazonaws.com";
        $this->dbname = "ourdb";
        $this->password = "Bhargav#123";
        $this->port = 3306;
        $this->username = "root";

   
        try {
            $dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname;
            $pdo = new PDO($dsn,$this->username,$this->password);
            $pdo ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            
       
            return $pdo;
           
        } catch (PDOException $th) {
            echo "Connection Failed"."".$th->getMessage();
        }
    }
}



