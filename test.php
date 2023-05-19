<?php
require_once 'config/Connection.php';
require_once 'model/Sampel.php';
require_once 'model/Kriteria.php';
require_once 'model/Group.php';
require_once 'model/Nilai.php';
session_start();
$page = $_GET['page'];
$action = $_GET['action'];
$bobot = [15,20,5,10,5,10];
switch ($page) {
    case "group":
        $group = new Group();
        switch ($action) {
            case "getData":
                
                break;
            case "save":
                
                break;
            case "delete":
                
            default:
                break;
        }

        break;

        case "kriteria":
        $sampel = new Sampel();
        $nilai = new Nilai();
        $kriteria = new Kriteria();
        switch ($action) {
            case "getData":
                break;
            case "getTotalBobot":
                break;
            case "save":
                break;
            case "delete":
                break;
            default:
                break;
        }
        break;

        case "sampel":
        $sampel = new Sampel();
        $nilai = new Nilai();
        $kriteria = new Kriteria();
        switch ($action) {
            case "getData":
                break;

            case "getRanking":
                $result = $sampel->getSampelByRanking();
                $data = array();
                while($row = mysqli_fetch_assoc($result)){
                    array_push($data, $row);
                }
                echo json_encode($data);
                break;

            case "updateRanking":
                $sampel->id = $_POST['id'];
                $sampel->ranking = $_POST['ranking'];
                $sampel->updateRanking();
                break;

            case "save":
                $sampel->id = $_GET['id'];
                $sampel->nama = $_GET['nama'];
                $sampel->fasilitas = $_GET['fasilitas'];
                $sampel->alamat = $_GET['alamat'];
                //$exists = $sampel->getSampelById();
                /*if(mysqli_num_rows($exists) == 0){
                    if($sampel->saveSampel()){
                        $result = $kriteria->getKriteria();
                        while($row = mysqli_fetch_assoc($result)){
                            $nilai->sampel_id = $_POST['id'];
                            $nilai->kriteria_id = $row['id'];
                            $nilai->saveNilai();
                        }
                        echo "Sampel berhasil disimpan";
                    }else{
                        echo "Sampel gagal disimpan";
                    }                    
                }else{
                    if($sampel->updateSampel()){
                        echo "Sampel berhasil dirubah";
                    }else{
                        echo "Sampel gagal dirubah";
                    }                    
                }*/
                break;
            case "delete":
                $id = $_POST['id'];
                $sampel->id = $id;
                $nilai->sampel_id = $id;
                $nilai->deleteBySampel();
                if($sampel->delete()){
                        echo "Sampel berhasil dihapus";                    
                }else{
                        echo "Sampel gagal dihapus";                    
                }
                break;
            default:
                break;
        }

        break;

        case "nilai":
        $nilai = new Nilai();
        switch ($action) {
            case "getData":
                if(isset($_POST['id'])){
                    $nilai->sampel_id = $_POST['sampel_id'];
                    $nilai->kriteria_id = $_POST['kriteria_id'];
                    $result = $nilai->getNilaiById();
                    echo json_encode(mysqli_fetch_object($result));
                }else{
                    $result = $nilai->getNilai();
                    $data = array();
                    while($row = mysqli_fetch_assoc($result)){
                        array_push($data, $row);
                    }
                    echo json_encode($data);                    
                }
            break;

            case "save":
                $nilai->sampel_id = $_POST['sampel_id'];
                $nilai->kriteria_id = $_POST['kriteria_id'];
                $nilai->nilai = $_POST['nilai'];
                $exists = $nilai->getNilaiByAll();
                if(mysqli_num_rows($exists) == 0){
                    if($nilai->saveNilai()){
                        echo "Nilai berhasil disimpan";
                    }else{
                        echo "Nilai gagal disimpan";
                    }                    
                }else{
                    if($nilai->updateNilai()){
                        echo "Nilai berhasil dirubah";
                    }else{
                        echo "Nilai gagal dirubah";
                    }                    
                }
            break;

            case "updateMatrik":
                $nilai->sampel_id = $_POST['sampel_id'];
                $nilai->kriteria_id = $_POST['kriteria_id'];
                $nilai->matrik = $_POST['matrik'];
                $nilai->updateMatrik();
                break;

            case "delete":
                $nilai->sampel_id = $_POST['sampel_id'];
                $nilai->kriteria_id = $_POST['kriteria_id'];
                if($nilai->delete()){
                        echo "Nilai berhasil dihapus";                    
                }else{
                        echo "Nilai gagal dihapus";                    
                }
            break;

            case "getSampel":
                if(isset($_POST['sampel_id'])){
                    $nilai->sampel_id = $_POST['sampel_id'];
                    $result = $nilai->getNilaiBySampel();
                    $data = array();
                    while($row = mysqli_fetch_assoc($result)){
                        array_push($data, $row);
                    }
                    echo json_encode($data);
                }
            break;

            case "getNilaiTotalByKategori":
                if(isset($_POST['kriteria_id'])){
                    $nilai->kriteria_id = $_POST['kriteria_id'];
                    $result = $nilai->getNilaiTotalByKategori();
                    echo json_encode(mysqli_fetch_object($result));
                }
            break;
            
            default:
                break;
        }

        break;

    default:
        break;
}
?>