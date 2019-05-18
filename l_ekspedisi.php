<?php 
	require_once('koneksi.php');
    
	$sql = "SELECT idekspedisi, nama from ekspedisi;";

	$r = mysqli_query($con, $sql);
	
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		array_push($result,array(
			"idekspedisi"=>$row['idekspedisi'],
			"nama"=>$row['nama']
		));
	}
	
	echo json_encode(array('result'=>$result));
	mysqli_close($con);
?>
