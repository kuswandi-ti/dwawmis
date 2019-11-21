<?php
	session_start();
	include "./../../config/connection.php";	
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$proses = $_GET['proses'];	
	//$sj_id = substr($_POST['txtshptocustsj'],0,-1);
	$sj_id = $_POST['txtshptocustsj'];	
	$sj_type = $_POST['rdo_sj'];
	
	if ($sj_type=='sj') {
		$query = mssql_query ("SELECT SJ_Number,Customer_Code,Customer_Name FROM TTrxHdr_Sls_SuratJalan WHERE SysId = '".$sj_id."'");
	} elseif ($sj_type=='manifest') {
		$query = mssql_query ("SELECT PO_Number,Customer_Code,Customer_Name FROM TTrxHdr_Sls_SuratJalan WHERE RIGHT(PO_Number,10) = '".$sj_id."'");
	} elseif ($sj_type=='dn') {
		$query = mssql_query ("SELECT DN_Number,Customer_Code,Customer_Name FROM TTrxHdr_Sls_SuratJalan WHERE DN_Number = '".$sj_id."'");
	}
	$result = mssql_fetch_array($query);
	
	if ($sj_type=='sj') {
		$sj_number = $result['SJ_Number'];
	} elseif ($sj_type=='manifest') {
		$sj_number = $result['PO_Number'];
		/* 09 Februari 2017 */
		/* Cek, jika manifest tetapi customer bukan ADM, tolak */
		$cek_customer_code = $result['Customer_Code'];
		if ($cek_customer_code == 'ADM') {
			print "<script>alert('Nomor PO ini tidak untuk pilihan MANIFEST, untuk customer ADM harap memilih DN.');location.href='./../../pages/stc/stc_sj.php?proses=$proses'</script>";
			return;
		}
	} elseif ($sj_type=='dn') {
		$sj_number = $result['DN_Number'];
	}	
	
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