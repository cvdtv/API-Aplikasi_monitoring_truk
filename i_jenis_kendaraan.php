<?php

    require_once('koneksi.php');

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $nama = $_POST['nama'];
        //Pembuatan Syntax SQL
        $sql = "INSERT INTO jenis_kendaraan(nama) values ('".$nama."');";
         
        //Eksekusi Query database
        if(mysqli_query($con, $sql)){
            // echo $sql;
            echo $nama.' Berhasil Di tambahkan.';
        }else{
            echo 'Gagal Menambahkan '.$nama;
            echo $sql;
        }
         // echo $sql;
        mysqli_close($con);
    }
?>
