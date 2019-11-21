<?php
	session_start();
	include "./../../config/connection.php";	
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$proses = $_GET['proses'];	
	//$sj_id = substr($_POST['txtshptocustsj'],0,-1);
	$sj_id = $_POST['txtshptocustsj'];
		
	$query = mssql_query ("SELECT * FROM TTrxHdr_Sls_SuratJalan WHERE SysId = '".$sj_id."'");
	$result = mssql_fetch_array($query);
	
	$sj_number = $result['SJ_Number'];
	if (!isset($_SESSION['sj_number_customer'])) {
		$_SESSION['sj_number_customer']=$sj_number;
	} else {
		$_SESSION['sj_number_customer']=$_SESSION['sj_number_customer'].', '.$sj_number;
	}
	
	$_SESSION['customer_code'] = $result['Customer_Code'];
	$_SESSION['customer_name'] = $result['Customer_Name'];
	
	$customer_code=$result['Customer_Code'];
	$customer_name=$result['Customer_Name'];
	
	if ($result) {
		header ("location:./../../pages/stc/stc_sj.php?proses=$proses&customer_code=$customer_code&customer_name=$customer_name");
	}else{
		print "<script>alert('Maaf Surat Jalan Tidak Terdaftar, Silahkan Hub Administrator');location.href='./../../pages/stc/stc_sj.php?proses=$proses'</script>";
	}
?>