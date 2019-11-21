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
			document.getElementById('txtshptocust').focus();
		}
		
		function Proses(proses)
		{
			location.href="./../../config/doc_num.php?proses="+proses;
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
			<tr>
              	<td align="center">
              		<button onclick="Proses('<?php echo $proses?>')">Proses To Customer</button>
              	</td>
              </tr>
		</table>
		
		<form method="post" 
		      enctype="multipart/form-data" 
			  name="shptocust" 
			  id="shptocust" action="stc_add.php?proses=<?php echo $proses?>">
			<table align="center" width="200" style="border:1px solid; border-colo:#CCCCCC;" >
				<tr>
					<td colspan="3">ID Surat Jalan :</td>
				</tr>
				<tr>
					<td colspan="3"><font color="red"><b><?php echo $_SESSION['sj_number_customer']?></b><font></td>
				</tr>
				<tr>
					<td colspan="3">Operator : <b><?php echo $_SESSION['operator']?></b></td>
				</tr>
				<tr>
					<td colspan="3">
						<div align="center"><input type="text" name="txtshptocust" size="28" id="txtshptocust" onkeyup="hanyaAngka(this);" /></div>
					</td>
				</tr>
				<tr>
              		<td align="center" width=20 bgcolor="#CCCCCC">No</td>
              		<td align="center" width=140 bgcolor="#CCCCCC">Barcode Id</td>
              		<td align="center" width=40 bgcolor="#CCCCCC">Action</td>
				</tr>
				
			<?php
				$query_temp = mssql_query("SELECT * FROM TTmp_Sls_ScanBarcodePallet WHERE Computer_Name='".$_SESSION['computer_name']."' AND Proses='".$proses."' ORDER BY Barcode_Id");
				$no = 1;
				while($result = mssql_fetch_array($query_temp)) {
					if ($no%2) {
						echo "<tr valign=top>";
					} else  {
						echo "<tr bgcolor=#CCCCCC valign=top>";
					}
					echo "<td width=34>$no</td>
                		<td width=335>$result[Barcode_Id]</td>
                		<td align='center'><a href='./../../config/delete.php?proses=$proses&barcode_id=$result[Barcode_Id]&cancel=1'>Cancel</a></td>
                		</tr>";
					$no++;
				}
             ?>
             	<tr>
              		<td colspan="3"><a href="./../../config/delete.php?proses=<?php echo $proses; ?>&delete=1">Back To Menu</a></td>
              	</tr>
            </table>
		</form>
	</body>
</html>