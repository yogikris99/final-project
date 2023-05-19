<?php
require_once 'config/Connection.php';
require_once 'model/Sampel.php';
require_once 'model/Kriteria.php';
require_once 'model/Group.php';
require_once 'model/Nilai.php';
session_start();
$page = $_GET['page'];
$action = $_GET['action'];
// $bobot = [15,20,5,10,5,10];
switch ($page) {
    case "group":
        $group = new Group();
        switch ($action) {
            case "getData":
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $group->id = $id;
                    $result = $group->getGroupById();
                    echo json_encode(mysqli_fetch_object($result));
                }else{
                    $result = $group->getGroup();
                    $data = array();
                    while($row = mysqli_fetch_assoc($result)){
                        array_push($data, $row);
                    }
                    echo json_encode($data);                    
                }
                break;
            case "save":
                $group->id = $_POST['id'];
                $group->nama = $_POST['nama'];
                $group->deskripsi = $_POST['deskripsi'];
                $exists = $group->getGroupById();
                if(mysqli_num_rows($exists) == 0){
                    if($group->saveGroup()){
                        echo "Group berhasil disimpan";
                    }else{
                        echo "Group gagal disimpan";
                    }                    
                }else{
                    if($group->updateGroup()){
                        echo "Group berhasil dirubah";
                    }else{
                        echo "Group gagal dirubah";
                    }                    
                }
                break;
            case "delete":
                $id = $_POST['id'];
                $group->id = $id;
                if($group->delete()){
                        echo "Group berhasil dihapus";                    
                }else{
                        echo "Group gagal dihapus";                    
                }
                break;
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
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $kriteria->id = $id;
                    $result = $kriteria->getKriteriaById();
                    echo json_encode(mysqli_fetch_object($result));
                }else{
                    $result = $kriteria->getKriteria();
                    $data = array();
                    while($row = mysqli_fetch_assoc($result)){
                        array_push($data, $row);
                    }
                    echo json_encode($data);                    
                }
                break;

            case "getTotalBobot":
                $result = $kriteria->getTotalBobot();
                echo json_encode(mysqli_fetch_object($result));
                break;

            case "save":
                $kriteria->nama = $_POST['nama'];
                $kriteria->deskripsi = $_POST['deskripsi'];
                $kriteria->tipe = $_POST['tipe'];
                $kriteria->bobot = $_POST['bobot'];
                if(isset($_POST['id']) && !empty($_POST['id'])){
                    $kriteria->id = $_POST['id'];
                    $exists = $kriteria->getKriteriaById();
                    if (mysqli_num_rows($exists) == 0) {
                        echo "Kriteria gagal dirubah";
                    } else {
                        if($kriteria->updateKriteria()){
                            echo "Kriteria berhasil dirubah";
                        }else{
                            echo "Kriteria gagal dirubah";
                        }
                    }  
                } else {
                    if($kriteria->saveKriteria()){
                        $getID = $kriteria->getKriteriaByName();
                        $rowID = mysqli_fetch_assoc($getID);
                        $kriteria_id = $rowID['id'];
                        $result = $sampel->getSampel();
                        while($row = mysqli_fetch_assoc($result)){
                            $nilai->sampel_id = $row['id'];
                            $nilai->kriteria_id = $kriteria_id;
                            $nilai->saveNilai();
                        }
                        echo "Kriteria berhasil disimpan";
                    }else{
                        echo "Kriteria gagal disimpan";
                    }    
                }
                break;
            case "delete":
                $id = $_POST['id'];
                $kriteria->id = $id;
                $nilai->kriteria_id = $id;
                $nilai->deleteByKriteria();
                if($kriteria->delete()){
                        echo "Kriteria berhasil dihapus";                    
                }else{
                        echo "Kriteria gagal dihapus";                    
                }
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
                if(isset($_POST['id'])){
                    $id = $_POST['id'];
                    $sampel->id = $id;
                    $result = $sampel->getSampelById();
                    echo json_encode(mysqli_fetch_object($result));
                }else{
                    $result = $sampel->getSampel();
                    $data = array();
                    while($row = mysqli_fetch_assoc($result)){
                        array_push($data, $row);
                    }
                    echo json_encode($data);                    
                }
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
                $sampel->id = $_POST['id'];
                $sampel->nama = $_POST['nama'];
                $sampel->fasilitas = $_POST['fasilitas'];
                $sampel->alamat = $_POST['alamat'];
                $sampel->ranking = 0;
                $exists = $sampel->getSampelById();
                if(mysqli_num_rows($exists) == 0){
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
                }
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
                $nilai->persentasi = $_POST['persentasi'];
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