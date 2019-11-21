<?php
	session_start();
	include "./../../config/connection.php";
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$barcode_id = $_POST['txtexptovend'];
	$proses = $_GET['proses'];
	$doc_number = $_GET['doc_number'];
	
 	$query_temp	= mssql_fetch_array(mssql_query("SELECT * FROM TTmp_Sls_ScanBarcodePallet WHERE Computer_Name ='".$_SESSION['computer_name']."' AND Proses='".$proses."'")) ;
	
	if(!$query_temp) {
		echo "<script>alert('Maaf Proses No Document $doc_number ini, belum terdapat barcode yang terScan.');location.href='wtv.php?proses=".$proses."'</script>";
	} else {
		$date = date("Y-m-d H:i:s");		
		
		$query_count = mssql_query("SELECT * FROM TTmp_Sls_ScanBarcodePallet WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."'");
 		$result = mssql_num_rows($query_count);
		
		/* 1. Insert ke tabel WTV */
		$query_wtv = mssql_query ("INSERT INTO TTrx_Sls_PalletOut_WarehouseToSupplier (Doc_Number,Barcode_Id,SJ_Subcont_Number,Barcode_From,Barcode_To,Scan_Date,Scan_Time,Scan_Flag,Rec_UserId,Rec_LastDate,Rec_LastTime)
            	     SELECT '".$doc_number."',Barcode_Id,'".$_SESSION['sj_number_vendor']."','WHS','SUPP','".$date."','".$date."',0,'".$_SESSION['operator']."','".$date."','".$date."' 
					 FROM TTmp_Sls_ScanBarcodePallet 
					 WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='$proses'");
		
		/* 2. Insert ke tabel Flow */
		$query_flow = mssql_query ("INSERT INTO TTrx_Flow_Pallet_Supplier (Doc_Number,Trx_Name,Barcode_Id) 
		                                        SELECT '".$doc_number."',Proses,Barcode_Id FROM TTmp_Sls_ScanBarcodePallet
												WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."'");												

		/* 3. Delete tabel flow */
		$delete_flow = mssql_query("DELETE FROM TTrx_Flow_Pallet_Supplier WHERE Trx_Name='vtw' AND Barcode_Id IN
                                               (SELECT Barcode_Id FROM TTmp_Sls_ScanBarcodePallet WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."')");
											   
											   
		/* 4. Delete tabel temporary */
		$delete_temp = mssql_query("DELETE FROM TTmp_Sls_ScanBarcodePallet WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."'"); 
		
		print "<script>alert('Sukses Tersimpan, No Document $doc_number dengan jumlah $result Pallet');location.href='./../../home.php'</script>";
	}
	
?>