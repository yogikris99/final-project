<?php


class Group {
    
    public $id;
    public $nama;
    public $deskripsi;
    
    private $conn;
    private $connection;
    private $sql;

    public function __construct() {
        $this->connection = new Connection();
        $this->conn = $this->connection->getConnection();
    }
    private function checkConnection(){
        if(!empty($this->connection->errorString)){
            return false;
        }
        return true;
    }

    public function getGroup(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM groups";
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
            echo 'wew '.$result;
        }
        return $result;
    }
    
    public function getGroupById(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM groups where id=".$this->id;
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }        
        return $result;
    }
    
    public function saveGroup(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "INSERT INTO groups(nama, deskripsi) VALUES('$this->nama', '$this->deskripsi')";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }        
    }
    public function updateGroup(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "UPDATE groups set nama='$this->nama', deskripsi='$this->deskripsi' where id=$this->id";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }        
    }

    public function delete(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "DELETE FROM groups WHERE id=$this->id";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }
    }
}
