<?php
	session_start();
?>

<html>
	<head>
	<meta charset="utf-8"/>
	<title>WMIS (Warehouse Management Information System)</title>
	</head>
	<style type="text/css">
		* {
			font-family: Trebuchet MS;
			font-size: x-small;
		}
	</style>
	<script language="javascript">
		window.onload = function() {
			document.getElementById('txtshptocustsj').focus();
		}
		
		function Proses(proses)
		{
			location.href="stc.php?proses="+proses;
		}
		
		function hanyaAngka(e) {
			if (!/^[0-9]+$/.test(e.value)) {
				e.value = e.value.substring(0,e.value.length-1);
			}
		}
	</script>
	<body>
<?php
	include "./../../config/connection.php";
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$proses = $_GET['proses'];
?>

		<h2 align="Center">Shipping To Customer</h2>		
		<table align="center" width="200" style="border:1px solid; border-color:#CCCCCC;" >
			<form method="post" 
				enctype="multipart/form-data" 
				name="shptocust" 
				id="shptocust" 
				action="stc_sj_add.php?proses=<?php echo $proses?>">
					<tr>
						<td colspan="3" align="center">
							<!--<font color="red">Masukan ID Surat Jalan</font>-->
							<input type="radio" name="rdo_sj" value="sj">SJ &nbsp;
							<input type="radio" name="rdo_sj" value="manifest">Manifest &nbsp;
							<input type="radio" name="rdo_sj" value="dn" checked>DN
						</td>
					</tr>	
					<tr><td></td></tr>
					<tr><td></td></tr>
					<tr>
						<td colspan="3">
							Operator : <b><?php echo $_SESSION['operator']?></b>
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<!--<div align="center"><input type="text" name="txtshptocustsj" size="28" id="txtshptocustsj" onkeyup="hanyaAngka(this);" /></div>-->
							<div align="center"><input type="text" name="txtshptocustsj" size="28" id="txtshptocustsj" /></div>
						</td>
					</tr>
					<tr>
						<!--<td colspan="3" align="center">No. SJ : <b><?php echo $_SESSION['sj_number_customer']; ?></b></td>-->
						<td colspan="3" align="center"><b><?php echo $_SESSION['sj_number_customer']; ?></b></td>
					</tr>
					<tr>
						<td colspan="3" align="center">
							<a href="./../../config/delete.php?proses=<?php echo $proses; ?>&remove_sj_customer=1">Remove</a></td>
					</tr>
			</form>
			<tr>
				<td colspan="3" align="center"><br><button onclick="Proses('<?php echo $proses?>')">Next</button></td>
			</tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr><td></td></tr>
			<tr>
				<td colspan="3"><a href="./../../config/delete.php?proses=<?php echo $proses; ?>&delete=1">Back To Menu</a></td>						
			</tr>
		</table>
	</body>
</html>