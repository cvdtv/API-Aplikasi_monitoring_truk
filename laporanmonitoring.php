<?php 
	require_once('koneksi.php');
	
	$status="";
	$filtermuat ="";

	if (isset($_GET['filtermuat'])) $filtermuat = $_GET['filtermuat'];

	if($filtermuat=="filtermuat"){
		$filter = " AND JAMMUAT = '0000-00-00 00:00:00' ";
	}elseif ($filtermuat=="filterkeluar") {
		$filter = " AND JAMKELUAR = '0000-00-00 00:00:00' AND JAMMUAT != '0000-00-00 00:00:00' ";
	}else {
		$filter = "";
	}

	$sql = "SELECT SJ_NO, NOPOL, JAMMASUK, JAMMUAT, JAMKELUAR FROM monitoringtruk WHERE DATE(JAMMASUK)>DATE_ADD(NOW(), INTERVAL -2 DAY)".$filter."ORDER BY WAKTU desc;";

	$r = mysqli_query($con, $sql);
	
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		if($row['JAMMUAT']=='0000-00-00 00:00:00'){
			$status = "Belum Muat";
		}elseif ($row['JAMKELUAR']!='0000-00-00 00:00:00') {
			$status = "Sudah Keluar";
		}elseif ($row['JAMMUAT']!='0000-00-00 00:00:00'&&$row['JAMKELUAR']=='0000-00-00 00:00:00') {
			$status = "Sudah Muat Tapi Belum Keluar";
		}

		$value = "No. SJ\t\t\t\t\t\t:\t\t".$row['SJ_NO']."\nNopol\t\t\t\t\t\t\t:\t\t".$row['NOPOL']."\nJam Masuk\t\t:\t\t".$row['JAMMASUK']."\nJam Muat\t\t\t:\t\t".$row['JAMMUAT']."\nJam Keluar\t\t:\t\t".$row['JAMKELUAR']."\nStatus\t\t\t\t\t\t:\t\t".$status;
		array_push($result,array(
			"value"=>$value
		));
	}
	
	echo json_encode(array('result'=>$result));
	mysqli_close($con);
?>
