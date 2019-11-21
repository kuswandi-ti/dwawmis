<?php
	session_start();
	include "./../../config/connection.php";
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$barcode_id = $_POST['txtshptocust'];
	$proses = $_GET['proses'];
	$doc_number = "";
	
 	$cek_barcode = mssql_fetch_array(mssql_query("SELECT * FROM QView_Sls_BarcodePalletAll WHERE Barcode_Id ='".$barcode_id."'"));
	$query_temp = mssql_fetch_array(mssql_query("SELECT * FROM TTmp_Sls_ScanBarcodePallet 
									WHERE Barcode_Id='".$barcode_id."' 
									AND Computer_Name='".$_SESSION['computer_name']."' 
									AND Proses='".$proses."'"));
	
	/* ----------------------------------------------------------------------------------------------------- */
	/* JIKA TANPA ETP */
	/* ----------------------------------------------------------------------------------------------------- */
	$query_etp = mssql_fetch_array(mssql_query("SELECT * 
	                                            FROM TTrx_Sls_PalletIn_CustomerToEkspedisi 
												WHERE Barcode_Id='".$barcode_id."' 
													AND Barcode_To='EXP' 
													AND Scan_Flag=0"));	
	$cek_flow = mssql_fetch_array(mssql_query("SELECT * 
	                                           FROM TTrx_Flow_Pallet_Customer 
											   WHERE Barcode_Id='".$barcode_id."' 
													AND Trx_Name='cte'"));
	/* ----------------------------------------------------------------------------------------------------- */
	
	/* ----------------------------------------------------------------------------------------------------- */
	/* JIKA DENGAN ETP */
	/* ----------------------------------------------------------------------------------------------------- */
	/* $query_etp = mssql_fetch_array(mssql_query("SELECT * 
	                                               FROM TTrx_Sls_PalletOut_EkspedisiToProduksi 
	                                               WHERE Barcode_Id='".$barcode_id."' 
														AND Barcode_To='PRD' 
														AND Scan_Flag=0"));
	// $cek_flow = mssql_fetch_array(mssql_query("SELECT * 
	                                              FROM TTrx_Flow_Pallet_Customer 
												  WHERE Barcode_Id='".$barcode_id."' 
														AND Trx_Name='etp'"));
	/* ----------------------------------------------------------------------------------------------------- */
	$cek_trx = mssql_fetch_array(mssql_query("SELECT * FROM QView_Sls_Trx_ScanBarcodePallet_STC WHERE Barcode_Id='".$barcode_id."'"));
	
	/* 1. Cek, apakah barcode ada di master pallet */
	if (!$cek_barcode) {
		echo "<script>alert('Barcode $barcode_id Tidak Ada di Database');
		     location.href='$proses.php?proses=".$proses."'</script>";
	}
	
	/* 2. Cek, apakah barcode ada aktif */
	else if (empty($cek_barcode['IsAktif']) or $cek_barcode['IsAktif'] <= 0) {
		echo "<script>alert('Barcode $barcode_id sudah tidak aktif : Barcode Status=$cek_barcode[Status]');
		     location.href='$proses.php?proses=".$proses."'</script>";
	}
	
	/* 3. Cek, apakah grup barcode masuk grup Customer */
	else if ($cek_barcode['GrupPallet_Id'] != 1) {
		echo "<script>alert('Proses tidak bisa dilanjutkan. Pallet ini bukan termasuk dalam grup CUSTOMER');
		     location.href='$proses.php?proses=".$proses."'</script>";
	}
	
	/* 4. Cek, apakah sudah ada barcode yang discan */
    else if (!$barcode_id) {
		echo "<script>alert('Anda Belum melakukan Scan, Mohon Ulangi!');
		     location.href='$proses.php?proses=".$proses."'</script>";
	}
	
	/* 5. Cek, apakah barcode sudah pernah discan */
    else if ($cek_trx) {
		$doc_number_trx = $cek_trx['Doc_Number'];
		$doc_date_trx_format = date('d-m-Y H:i:s',strtotime($cek_trx['Scan_Time']));
		echo "<script>alert('Pallet masih ada di Customer (Transaksi STC). No. Transaksi $doc_number_trx tanggal $doc_date_trx_format');
		     location.href='$proses.php?proses=".$proses."'</script>";
	}
	
	/* ----------------------------------------------------------------------------------------------------- */
	/* JIKA TANPA ETP */
	/* ----------------------------------------------------------------------------------------------------- */
	/* 6. Cek, apakah barcode masih di CUSTOMER atau bukan */
    else if (!$cek_flow) {
		echo "<script>alert('Posisi pallet tidak ada di STORE / EXPEDISI!');
		     location.href='$proses.php?proses=".$proses."'</script>";
	}
	/* ----------------------------------------------------------------------------------------------------- */
	/* ----------------------------------------------------------------------------------------------------- */
	/* JIKA DENGAN ETP */
	/* ----------------------------------------------------------------------------------------------------- */
	/* 6. Cek, apakah barcode masih di PRODUKSI atau bukan */
    /* else if (!$cek_flow) {
		echo "<script>alert('Posisi pallet tidak ada di PRODUKSI!');
		     location.href='$proses.php?proses=".$proses."'</script>";
	} */
	/* ----------------------------------------------------------------------------------------------------- */	
	
	/* 7. Cek, apakah barcode sudah discan di transaksi ini */
	else if ($query_temp) {
		echo "<script>alert('Barcode $barcode_id sudah discan di transaksi ini');
		     location.href='$proses.php?proses=".$proses."'</script>";
	} 
	
	else {
		$barcode_id_temp = $cek_barcode['Barcode_Id'];
		$kode_pallet_temp = $cek_barcode['Kode_Pallet'];
		$jenis_pallet_temp = $cek_barcode['Kode_JenisPallet'];
		$nama_pallet_temp = $cek_barcode['Nama_Pallet'];
		$pallet_number_temp = $cek_barcode['Pallet_No'];	
		
		$_SESSION['doc_num_etp_source'] = ($query_etp['Doc_Number']);
		
		/* jika belum discan, simpan informasi pallet ke tabel temporary (TTmp_Sls_ScanBarcodePallet) */
		$write = mssql_query("INSERT INTO TTmp_Sls_ScanBarcodePallet (Doc_Number,Barcode_Id,Kode_Pallet,Jenis_Pallet,Nama_Pallet,
		                     Pallet_No,Computer_Name,Proses,Rec_Id) VALUES 
							 ('".$doc_number."','".$barcode_id_temp."','".$kode_pallet_temp."','".$jenis_pallet_temp."',
							 '".$nama_pallet_temp."','".$pallet_number_temp."','".$_SESSION['computer_name']."',
							 '".$proses."','".$_SESSION['operator']."')");				
		echo "<script>location.href='$proses.php?proses=".$proses."'</script>";
	}
?>