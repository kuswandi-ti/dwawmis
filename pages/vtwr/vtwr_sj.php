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
			document.getElementById('txtvendtowhsretursj').focus();
		}
		
		function Proses(proses)
		{
			location.href="vtwr.php?proses="+proses;
		}
	</script>
	<body>
<?php
	include "./../../config/connection.php";
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$proses = $_GET['proses'];
?>

		<h2 align="Center">Vendor To Warehouse (Retur)</h2>
		<form method="post" 
		      enctype="multipart/form-data" 
			  name="vendtowhsretursj" 
			  id="vendtowhsretursj" 
			  action="vtwr_sj_add.php?proses=<?php echo $proses?>">
			<table align="center" width="200" style="border:1px solid; border-color:#CCCCCC;" >
				<tr>
					<td colspan="3" align="center">
						<font color="red">Masukkan No Surat Jalan DWA</font>
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
						<div align="center"><input type="text" name="txtvendtowhsretursj" size="28" id="txtvendtowhsretursj" /></div>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">No. SJ DWA : <b><?php echo $_SESSION['sj_number_vendor_retur']; ?></b></td>
				</tr>
				<tr>
					<td colspan="3" align="center">
					    <a href="./../../config/delete.php?proses=<?php echo $proses; ?>&remove_sj_retur_vendor=1">Remove SJ</a></td>
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