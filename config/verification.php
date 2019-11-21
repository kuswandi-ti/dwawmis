<?php
	session_start();
	include "connection.php";
	
	$connection_finacct=new Connection();	
	$connection_finacct->connection_finacct_open();
	
	//$NIK = substr($_POST['NIK'],0,-1);
	$NIK = $_POST['NIK'];
		
	$query = mssql_query ("SELECT * FROM BCD_Operator WHERE NIK = '".$NIK."'");
	$result = mssql_fetch_array($query);
		
	if ($result) {
		$_SESSION['operator']=$result['Nama'];
		$_SESSION['etp'] = $result['ETP'];
		$_SESSION['ptl'] = $result['PTL'];
		$_SESSION['stc'] = $result['STC'];
		$_SESSION['cte'] = $result['CTE'];
		$_SESSION['vtw'] = $result['VTW'];
		$_SESSION['wtv'] = $result['WTV'];
		$_SESSION['computer_name'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		header ('location:./../home.php');
	} else {
		print "<script>alert('Maaf User Anda Tidak Terdaftar, Silahkan Hub Administrator');location.href='./../login.php'</script>";
	}
	
	$connection_finacct->connection_finacct_close();
?>
