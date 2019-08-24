<?php
			// require_once "notification.php";
			// $notification = new Notification();
			// echo $notification->sendFCMSingle("", "", "eASjf7WXTWU:APA91bEQP2j9ZgwMwN0xI4l_y-nC6r7nZlnFBhxA4O2qb7QfvdQHD-gh8HgywDYexoKA4Alr_MyGFs52SEiE2ilQFihgNZBLw-KvZnhYlLopuQBC9TfNybaNrLinBxhGLYBazg1UTVkl", $notification->setNotification("Monitoring Truk", "tes masuk"));

	require_once('koneksi.php');

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		if (isset($_POST['nosj'])) $nosj = $_POST['nosj'];
		if (isset($_POST['OPSALES'])) $OPSALES = $_POST['OPSALES'];
		if (isset($_POST['nopol'])) $nopol = $_POST['nopol'];
		if (isset($_POST['cusnama'])) $cusnama = $_POST['cusnama'];
		if (isset($_POST['optjo'])) $optj = $_POST['optj'];
	
		if (isset($_POST['filter'])){
	
			$filter = $_POST['filter'];
			if ($filter=="muat")
			{
				$str = "Muat";
				$sql = "UPDATE moonitoringtruk SET JAMMUAT=NOW() WHERE SJ_NO='$nosj' and JAMMUAT='0000-00-00 00:00:00';";
			}
			else if ($filter=="keluar") 
			{
				$str = "Keluar";
				$sql = "UPDATE monitoringtruk SET JAMKELUAR=NOW() WHERE SJ_NO='$nosj' and JAMKELUAR='0000-00-00 00:00:00';";
				$sql .= "UPDATE suratjalan SET VALID=1 WHERE SJ_NO='$nosj';";
			}
			else if ($filter == "batal") {
				$sql = "UPDATE monitoringtruk set SJ_NO='-', JAMKELUAR=NOW() where (SJ_NO='' or SJ_NO='-') and NOPOL='$nosj' and JAMMUAT='0000-00-00 00:00:00' and JAMKELUAR='0000-00-00 00:00:00'";
			}
	
		}
		
		if(mysqli_multi_query($con,$sql)){

			require_once "notification.php";
			if ($filter== "batal") {
				echo $sql." - ".$query." - ".$tokensales;
			}else{
				$notification = new Notification();
				$query = "SELECT token from sles where keysales='$OPSALES'";
				$tokensales = mysqli_fetch_row(mysqli_query($con, "SELECT token from sales where keysales='$OPSALES'"));

				$result = $notification->sendFCMSingle("", "", $tokensales[0], $notification->setNotification("Monitoring Truk", "Truk nopol ".$nopol.", Tujuan ".$optj."  sudah ".$str));		
				echo $sql." - ".$query." - ".$tokensales;		
			}

			echo 'Berhasil Set Jam Keluar '.$sql;
			//echo $sql." - ".$query." - ".$tokensales;

		}else{

			echo 'Gagal Proses Jam Keluar';
			echo $sql;
		}
		
		// echo $sql;
		mysqli_close($con);
	
	}
?>