<?php
	session_start();
	
	if (!isset($_SESSION['operator'])) {
		"location.href='index.php";
	}
?>

<html>
	<head>
		<title></title>
	</head>
	<body>
		<?php include './login.php'; ?>
	</body>
</html>