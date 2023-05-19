<?php

define("USERNAME", "root");
define("PASSWORD", "");
define("SERVER", "localhost");
define("DBNAME", "kost");
class Connection {
    
    public $errorString;

    function getConnection(){
        $conn = mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME);
        if(!$conn){
            echo 'connect error';
            die("Connection Failed : ".  mysqli_connect_error());
            $this->errorString = mysqli_connect_error();
        }
        return $conn;
    }
}

