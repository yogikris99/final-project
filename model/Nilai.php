<?php


class Nilai {
    
    public $sampel_id;
    public $kriteria_id;
    public $nilai;
    public $matrik;
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

    public function getNilai(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM nilai_sampel";
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }
        return $result;
    }
    
    public function getNilaiByAll(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT * FROM nilai_sampel where sampel_id= ".$this->sampel_id." and kriteria_id = ".$this->kriteria_id;
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }        
        return $result;
    }

    public function getNilaiBySampel(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "SELECT a.*, b.nama as nama_kriteria, b.bobot , c.nama FROM nilai_sampel a LEFT JOIN kriteria b on a.kriteria_id=b.id LEFT JOIN sampel c on a.sampel_id=c.id where a.sampel_id= ".$this->sampel_id;
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }        
        return $result;
    }

    public function getNilaiTotalByKategori(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        //$this->sql = "SELECT kriteria_id, SUM(nilai) as nilai_total FROM nilai_sampel where kriteria_id = ".$this->kriteria_id;
        $this->sql = "SELECT a.kriteria_id, MAX(a.nilai) as nilai_max, MIN(a.nilai) as nilai_min, b.tipe FROM nilai_sampel a LEFT JOIN kriteria b on a.kriteria_id=b.id where a.kriteria_id = ".$this->kriteria_id;
        $result = $this->conn->query($this->sql);
        if(mysqli_error($this->conn)){
            $result = mysqli_error($this->conn);
        }        
        return $result;
    }
    
    public function saveNilai(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "INSERT INTO nilai_sampel(sampel_id, kriteria_id, nilai, matrik, persentasi) VALUES($this->sampel_id, $this->kriteria_id, 0, 0, 0)";
        $result = $this->conn->query($this->sql);
        echo $result;
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }        
    }

    public function updateNilai(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "UPDATE nilai_sampel set nilai=$this->nilai where sampel_id=$this->sampel_id and kriteria_id=$this->kriteria_id";
        $result = $this->conn->query($this->sql);
        if($result){
            return true;
        }else{
            $this->connection->errorString = mysqli_error($this->conn);
            return false;
        }        
    }

    public function updateMatrik(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
        }        
        $this->sql = "UPDATE nilai_sampel set matrik=$this->matrik where sampel_id=$this->sampel_id and kriteria_id=$this->kriteria_id";
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
                
            $this->sql = "DELETE FROM nilai_sampel WHERE sampel_id=$this->sampel_id and kriteria_id=$this->kriteria_id";
            $result = $this->conn->query($this->sql);
            if($result){
                return true;
            }else{
                $this->connection->errorString = mysqli_error($this->conn);
                return false;
            }
        }
    }

    public function deleteByKriteria(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
                
            $this->sql = "DELETE FROM nilai_sampel WHERE kriteria_id=$this->kriteria_id";
            $result = $this->conn->query($this->sql);
            if($result){
                return true;
            }else{
                $this->connection->errorString = mysqli_error($this->conn);
                return false;
            }
        }
    }

    public function deleteBySampel(){
        if(!$this->checkConnection()){
            return $this->connection->errorString;
                
            $this->sql = "DELETE FROM nilai_sampel WHERE sampel_id=$this->sampel_id";
            $result = $this->conn->query($this->sql);
            if($result){
                return true;
            }else{
                $this->connection->errorString = mysqli_error($this->conn);
                return false;
            }
        }
    }

}
