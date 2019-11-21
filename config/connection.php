<?php
	include 'var_global.php';
	
	class Connection {
		function connection_dwasys_open() {
			$connect = mssql_connect(HOST_DWASYS, USER_DWASYS, PASS_DWASYS);
			if ($connect) {
				mssql_select_db(DB_DWASYS, $connect) or die ("Could't open the database");
			} else {
				die ("this server is not actived");
			}
		}
			
		function connection_dwasys_close() {
			mssql_close(mssql_connect(HOST_DWASYS, USER_DWASYS, PASS_DWASYS));
		}		
		
		function connection_finacct_open() {
			$connect = mssql_connect(HOST_DWAFINACCT, USER_DWAFINACCT, PASS_DWAFINACCT);
			if ($connect) {
				mssql_select_db(DB_DWAFINACCT, $connect) or die ("Could't open the database");
			} else {
				die ("this server is not actived");
			}
		}
			
		function connection_finacct_close() {
			mssql_close(mssql_connect(HOST_DWAFINACCT, USER_DWAFINACCT, PASS_DWAFINACCT));
		}
		
	}
	
	class Stored_Procedure 
	{
		function left($str, $length) {
			return substr($str, 0, $length);
		}

		function right($str, $length) {
			return substr($str, -$length);
		}
			
		public function sp_create_docnumber($proses,$computer_name)
		{
			$connection_dwasys = mssql_connect(HOST_DWASYS, USER_DWASYS, PASS_DWASYS);
			if ($connection_dwasys) {
				mssql_select_db(DB_DWASYS, $connection_dwasys) or die ("Could't open the database");
			} else {
				die ("this server is not actived");
			}
			
			$page = $proses."_proses";
			$proses = $_GET['proses'];
			if ($proses) {
				$stmt = mssql_init('spCreateDocNumber',$connection_dwasys);
						
				if ($proses=='etp'){
					$trx_name = "PalletOut_EkspedisiToProduksi";
					$table = "TTrx_Sls_PalletOut_EkspedisiToProduksi";
				} else if($proses=='stc'){
					$trx_name = "PalletOut_ShippingToCustomer";
					$table = "TTrx_Sls_PalletOut_ShippingToCustomer";
				} else if ($proses=='cte'){
					$trx_name = "PalletIn_CustomerToEkspedisi";
					$table = "TTrx_Sls_PalletIn_CustomerToEkspedisi";
				} else if ($proses=='wtv'){
					$trx_name = "PalletOut_WarehouseToSupplier";
					$table = "TTrx_Sls_PalletOut_WarehouseToSupplier";
				} else if ($proses=='vtw' || $proses=='vtwr'){
					$trx_name = "PalletIn_SupplierToWarehouse";
					$table = "TTrx_Sls_PalletIn_SupplierToWarehouse";
				}
						
				$trx_month = date('n');
				$trx_year = date('Y');
				$new_doc_number = '';
						
				// Executed Stored Procedure Procedure
				mssql_bind($stmt, '@TransName', $trx_name, SQLVARCHAR, false, false,500);
				mssql_bind($stmt, '@TransMonth', $trx_month, SQLVARCHAR, false, false,50);
				mssql_bind($stmt, '@TransYear', $trx_year, SQLVARCHAR, false, false,50);
				mssql_bind($stmt, '@NewDocNumber', $new_doc_number, SQLVARCHAR, true);
					
				mssql_execute($stmt);
				mssql_free_statement($stmt);
				
				$right_function=new Stored_Procedure;
				$nourut=$right_function->right("0000".$new_doc_number,5);				
				
				$doc_number = strtoupper(($proses=='vtwr') ? 'vtw' : $proses).'-'.date('y').'/'.date('m').'-'.$nourut;				
							
				header("location:./../pages/$proses/$page.php?proses=$proses&doc_number=$doc_number");
				
			}
		}
	}
?>