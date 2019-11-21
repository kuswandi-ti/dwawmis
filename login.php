<?php
	session_start();
	session_destroy();
?>

<html>
	<head>
		<title>WMIS (Warehouse Management Information System)</title>
		<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
	</head>
	
	<script language="JavaScript">
		window.onload = function() {
			document.getElementById('NIK').focus();
		}
		
		$(document).ready(function(){
			$("#NIK").focus();
		});
		
		function changeScreenSize(h,w)
		{
			window.resizeTo(h,w)
		}
		
		function hanyaAngka(e) {
			if (!/^[0-9]+$/.test(e.value)) {
				e.value = e.value.substring(0,e.value.length-1);
			}
		}
	</script>
	
	<body onLoad="changeScreenSize(300,200)">
		<form method="post" 
		      action="config/verification.php" 
			  enctype="multipart/form-data" 
			  name="LogIn" 
			  id="LogIn">
			<table width="200" 
				   height="97" 
				   border="0" 
				   align="center" 
				   style="border:1px solid rgb(194,194,194);">
				<tr>
					<td colspan="3" 
						align="center" 
						bgcolor="#F0F4F9">
						<font color="#565957" 
						      style="font-family: Trebuchet MS; font-size: x-small;">Scan Barcode NIK Anda
						</font>
					</td>
				</tr>
				<tr>
					<td align="right">
						<font color="#565957" 
						      style="font-family: Trebuchet MS; font-size: x-small;">NIK
						</font>
					</td>
					<td>:</td>
					<td>
						<input type="text" 
						       name="NIK" 
							   size="20" 
							   id="NIK" 
							   onKeyPress="length(8);" 
							   onkeyup="hanyaAngka(this);" />
					</td>
				</tr>
			</table>
		</form>		
	</body>
</html>
