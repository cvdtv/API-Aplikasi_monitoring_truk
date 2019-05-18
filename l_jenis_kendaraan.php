<?php 
	require_once('koneksi.php');
    
	$sql = "SELECT idjenis_kendaraan, nama from jenis_kendaraan;";

	$r = mysqli_query($con, $sql);
	
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		array_push($result,array(
			"idjenis_kendaraan"=>$row['idjenis_kendaraan'],
			"nama"=>$row['nama']
		));
	}
	
	echo json_encode(array('result'=>$result));
	mysqli_close($con);
?>
