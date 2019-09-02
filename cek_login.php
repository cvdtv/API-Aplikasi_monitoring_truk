<?php 
  require_once('koneksi.php');

    $uuid = "";
    $jabatan = "sekuriti";
    if(isset($_POST['uuid'])) $uuid = $_POST["uuid"];
    if(isset($_POST['jabatan'])) $jabatan = $_POST["jabatan"];

    $sql = "SELECT * FROM pengguna where uuid='".$uuid."'";

    $r = mysqli_query($con, $sql);

    $result = array();
    $row = mysqli_fetch_array($r);

    $masuk = 8;
    $keluar = 8;
    $loading = 8; 
    $batal = 8;
    $laporan = 8;

    if ($row==true) {
      
      if ($row['jabatan']=='sekuriti')
      {
        $masuk = 0;
        $keluar = 0;
        $loading = 8; 
        $batal = 0;
        $admin = 8;
      } else if($row['jabatan']=="muatan")
      {
        $keluar = 8; 
        $masuk = 8;
        $loading = 0;
        $batal=8;
        $admin=8;
      }else if($row['jabatan']=="admin")
      {
        $keluar = 0; 
        $masuk = 0;
        $loading = 0;
        $batal = 0;
        $admin = 0;
      }
      else
      {
        $masuk = 8;
        $keluar = 8;
        $loading = 8; 
        $batal = 8;
        $admin = 8;
      }
    }
    else
    {
      $masuk = 8;
      $keluar = 8;
      $loading = 8; 
      $batal =8;
    }
  
    array_push($result,array(
        "uuid"=>$row['uuid'],
        "jabatan"=>$row['jabatan'],
        "masuk"=> $masuk,
        "keluar"=> $keluar,
        "loading"=> $loading,
        "batal"=>$batal,
        "admin"=>$admin
    ));
    
    echo json_encode(array('result'=>$result));
    // echo $sql;
    mysqli_close($con);
?>
