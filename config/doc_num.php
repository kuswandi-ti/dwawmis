<?php
	session_start();
	include "connection.php";
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$proses=$_GET['proses']; 
	
	$cek_scan=mssql_query("SELECT * FROM TTmp_Sls_ScanBarcodePallet WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."'");	
	$num_rows=mssql_num_rows($cek_scan);
	$result=mssql_fetch_array($cek_scan);
	
	if ($num_rows<=0) {
		echo "<script>alert('Belum ada barcode pallet yang discan');location.href='./../pages/$proses/$proses.php?proses=$proses'</script>";
	} else {			
		$sp_dwasys=new Stored_Procedure();	
		$sp_dwasys->sp_create_docnumber($proses,$_SESSION['computer_name']);
	}
	
	$connection_dwasys->connection_dwasys_close();
?>
	