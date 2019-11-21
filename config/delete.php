<?php
	session_start();
	include "connection.php";
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$date = date("Y-m-d h:i:s");
	$proses = $_GET['proses'];
	$barcode_id=$_GET['barcode_id'];
	$delete = $_GET['delete'];
	$cancel = $_GET['cancel'];
	$remove_sj_customer = $_GET['remove_sj_customer'];
	$remove_sj_vendor = $_GET['remove_sj_vendor'];
	$remove_sj_retur_vendor = $_GET['remove_sj_retur_vendor'];
	
	if ($delete==1) {
		$query_log = mssql_query("INSERT INTO TTmp_Sls_LogBarcodePalletCancel (Barcode_Id,Barcode_From,Rec_Id,Scan_Date,Cancel_Date)
		             SELECT Barcode_Id,Proses,Rec_Id,'".$date."','".$date."' FROM TTmp_Sls_ScanBarcodePallet 
					 WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."'");
		$query_delete = mssql_query("DELETE FROM TTmp_Sls_ScanBarcodePallet WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."'");		
		header("location:./../home.php");
	}	
	
	if ($cancel==1) {
		$query_log = mssql_query("INSERT INTO TTmp_Sls_LogBarcodePalletCancel (Barcode_Id,Barcode_From,Rec_Id,Scan_Date,Cancel_Date)
		             SELECT Barcode_Id,Proses,Rec_Id,'".$date."','".$date."' FROM TTmp_Sls_ScanBarcodePallet 
					 WHERE Barcode_Id='".$barcode_id."' AND Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."'");
		$query_cancel = mssql_query("DELETE FROM TTmp_Sls_ScanBarcodePallet WHERE Barcode_Id='".$barcode_id."' AND Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."'");
		header("location:./../pages/$proses/$proses.php?proses=$proses");
	}
	
	if ($remove_sj_customer==1) {
		unset($_SESSION['sj_number_customer']);
		header("location:./../pages/stc/stc_sj.php?proses=$proses");
	}
	
	if ($remove_sj_vendor==1) {
		unset($_SESSION['sj_number_vendor']);
		header("location:./../pages/wtv/wtv_sj.php?proses=$proses");
	}
	
	if ($remove_sj_retur_vendor==1) {
		unset($_SESSION['sj_number_vendor_retur']);
		header("location:./../pages/vtwr/vtwr_sj.php?proses=$proses");
	}
	
	$connection_dwasys->connection_dwasys_close(); 
?>