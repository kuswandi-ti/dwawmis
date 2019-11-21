<?php
	session_start();
	include "./../../config/connection.php";	
	
	$connection_dwafinacct=new Connection();	
	$connection_dwafinacct->connection_finacct_open();
	
	$proses = $_GET['proses'];	
	$sj_no = $_POST['txtvendtowhsretursj'];
		
	$query = mssql_query ("SELECT * FROM BCD_Outgoing_Mat WHERE trantype='MOS' AND docno = '".$sj_no."'");
	$result = mssql_fetch_array($query);
	
	$sj_number = $result['docno'];
	if (!isset($_SESSION['sj_number_vendor_retur'])) {
		$_SESSION['sj_number_vendor_retur']=$sj_number;
	} else {
		$_SESSION['sj_number_vendor_retur']=$_SESSION['sj_number_vendor_retur'].', '.$sj_number;
	}
	
	if ($result) {
		header ("location:./../../pages/vtwr/vtwr_sj.php?proses=$proses");
	} else {
		print "<script>alert('Maaf Surat Jalan Tidak Terdaftar, Silahkan Hub Administrator');location.href='./../../pages/vtwr/vtwr_sj.php?proses=$proses'</script>";
	}
?>