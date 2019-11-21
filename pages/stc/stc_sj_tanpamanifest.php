<?php
	session_start();
?>

<html>
	<head><title>WMIS (Warehouse Management Information System)</title></head>
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
		<form method="post" 
		      enctype="multipart/form-data" 
			  name="shptocust" 
			  id="shptocust" 
			  action="stc_sj_add.php?proses=<?php echo $proses?>">
			<table align="center" width="200" style="border:1px solid; border-color:#CCCCCC;" >
				<tr>
					<td colspan="3" align="center">
						<font color="red">Masukan ID Surat Jalan</font>
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
						<div align="center"><input type="text" name="txtshptocustsj" size="28" id="txtshptocustsj" onkeyup="hanyaAngka(this);" /></div>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">No. SJ : <b><?php echo $_SESSION['sj_number_customer']; ?></b></td>
				</tr>
				<tr>
					<td colspan="3" align="center">
					    <a href="./../../config/delete.php?proses=<?php echo $proses; ?>&remove_sj_customer=1">Remove SJ</a></td>
				</tr>
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
		</form>
	</body>
</html>