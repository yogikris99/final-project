<?php

class Kriteria {
    
    public $id;
    public $nama;
    public $deskripsi;
    public $tipe;
    public $bobot;
    public $groups_id;
    
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

    public function getKriteria(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM kriteria";
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
            echo 'wew '.$result;
        }
        return $result;
    }
    
    public function getKriteriaById(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM kriteria where id=".$this->id;
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }        
        return $result;
    }

    public function getKriteriaByName(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM kriteria where nama='".$this->nama."'";
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }        
        return $result;
    }
    
    public function getTotalBobot(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "select sum(bobot) as bobot from kriteria";
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }        
        return $result;
    }

    public function saveKriteria(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "INSERT INTO kriteria(nama, deskripsi, tipe, bobot, groups_id) VALUES('$this->nama', '$this->deskripsi', '$this->tipe', $this->bobot, 1)";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }        
    }
    public function updateKriteria(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "UPDATE kriteria set nama='$this->nama', deskripsi='$this->deskripsi', tipe='$this->tipe',bobot=$this->bobot where id=$this->id";
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
        $this->sql = "DELETE FROM kriteria WHERE id=$this->id";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }
    }
}
