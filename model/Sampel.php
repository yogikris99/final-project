<?php


class Sampel {
    
    public $id;
    public $nama;
    public $fasilitas;
    public $alamat;
    public $ranking;
    
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

    public function getSampel(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM sampel";
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }
        return $result;
    }

    public function getSampelByRanking(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM sampel order by ranking DESC";
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }
        return $result;
    }
    
    public function getSampelByid(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM sampel where id=".$this->id;
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }        
        return $result;
    }
    
    public function saveSampel(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "INSERT INTO sampel(id, nama,fasilitas,alamat,ranking) VALUES($this->id, '$this->nama','$this->fasilitas','$this->alamat',$this->ranking)";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }        
    }

    public function updateSampel(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "UPDATE sampel set nama='$this->nama',fasilitas='$this->fasilitas',alamat='$this->alamat' where id=$this->id";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }        
    }

    public function updateRanking(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "UPDATE sampel set ranking=$this->ranking where id=$this->id";
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
        $this->sql = "DELETE FROM sampel, nilai_sampel USING sampel, nilai_sampel WHERE sampel.id = nilai_sampel.sampel_id AND sampel.id = $this->id";
        // $this->sql = "DELETE FROM sampel WHERE id=$this->id";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }
    }
}
