<?php
	session_start();
	
	unset($_SESSION['sj_number_customer']);
	unset($_SESSION['customer_code']);
	unset($_SESSION['customer_name']);
	unset($_SESSION['doc_num_etp_source']);
	unset($_SESSION['doc_num_stc_source']);	
	unset($_SESSION['sj_number_vendor']);
	unset($_SESSION['sj_number_vendor_retur']);
	unset($_SESSION['doc_num_wtv_source']);
	
	include 'config/var_global.php';
?>

<html>
	<head>
		<title>WMIS (Warehouse Management Information System)</title>
		<style type="text/css">
			* {
				font-family: Trebuchet MS;
				font-size: x-small;
			}
		</style>
	</head>
	<body>
		<div align="center">
			<table width="200" border="0" style="border:1px solid rgb(194,194,194);">
				<?php
					if ($_SESSION['etp']==1) { ?> 
						<tr>
							<td>
								<div align="center">	
									<!--<img src="images/ok.png" />-->
									<a href="pages/etp/etp.php?proses=etp">Ekspedisi To Produksi</a>
								</div>
							</td>
						</tr>
					<?php 
					}
					
					if ($_SESSION['stc']==1) { ?> 
						<tr>
							<td>
								<div align="center">
									<!--<img src="images/ok.png" />-->
									<a href="pages/stc/stc_sj.php?proses=stc">Shipping To Customer</a>
								</div>
							</td>
						</tr>
					<?php 
					}
					
					if ($_SESSION['cte']==1) { ?> 
						<tr>
							<td>
								<div align="center">
									<!--<img src="images/ok.png" />-->
									<a href="pages/cte/cte.php?proses=cte">Customer To Ekspedisi</a>
								</div>
							</td>
						</tr>
					<?php 
					}
					
					if ($_SESSION['wtv']==1) { ?> 
						<tr>
							<td>
								<div align="center">
									<!--<img src="images/ok.png" />-->
									<a href="pages/wtv/wtv_sj.php?proses=wtv">Warehouse To Vendor</a>
								</div>
							</td>
						</tr>
					<?php 
					}
				
					if ($_SESSION['vtw']==1) { ?> 
						<tr>
							<td>
								<div align="center">
									<!--<img src="images/ok.png" />-->
									<a href="pages/vtw/vtw.php?proses=vtw">Vendor To Warehouse</a>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div align="center">
									<!--<img src="images/ok.png" />-->
									<a href="pages/vtwr/vtwr_sj.php?proses=vtwr">Vendor To Warehouse (Retur)</a>
								</div>
							</td>
						</tr>
					<?php } ?>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align="center">Login as : <font color="red"><b><?php echo $_SESSION['operator']; ?></b></font></td>
						</tr>
						<tr>
							<td align="center">Dev. Addr. : <font color="red"><b><?php echo $_SESSION['computer_name']; ?></b></font></td>
						</tr>
						<tr>
							<td align="center">Server : <font color="red"><b><?php echo HOST_DWASYS; ?></b></font></td>
						</tr>
						<tr>
							<td align="center"><b><font color="red"><a href="login.php">>> Logout <<</a></font></b></td>
						<tr>
			</table>
		</div>
		
		
	</body>
</html>