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
			document.getElementById('txtwhstovendsj').focus();
		}
		
		function Proses(proses)
		{
			location.href="wtv.php?proses="+proses;
		}
	</script>
	<body>
<?php
	include "./../../config/connection.php";
	
	$connection_dwasys=new Connection();	
	$connection_dwasys->connection_dwasys_open();
	
	$proses = $_GET['proses'];
?>

		<h2 align="Center">Warehouse To Vendor</h2>		
			<table align="center" width="200" style="border:1px solid; border-color:#CCCCCC;" >
				<form method="post" 
					enctype="multipart/form-data" 
					name="whstovendsj" 
					id="whstovendsj" 
					action="wtv_sj_add.php?proses=<?php echo $proses?>">
					<tr>
						<td colspan="3" align="center">
							<font color="red">Masukkan No Surat Jalan</font>
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
							<div align="center"><input type="text" name="txtwhstovendsj" size="28" id="txtwhstovendsj" /></div>
						</td>
					</tr>
					<tr>
						<td colspan="3" align="center">No. SJ : <b><?php echo $_SESSION['sj_number_vendor']; ?></b></td>
					</tr>
					<tr>
						<td colspan="3" align="center">
							<a href="./../../config/delete.php?proses=<?php echo $proses; ?>&remove_sj_vendor=1">Remove SJ</a></td>
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
		</form>
	</body>
</html>