<head>
	<meta charset="UTF-8">
	<title>CONquest: Event Planner</title>
	<link rel="icon" type="images/x-icon" href="images/icon.png">
	<link href="css/common-style.css" type="text/css" rel="stylesheet" />
</head>

<?php
	$connection = new mysqli('localhost', 'root', '', 'dbcatubigf2');
	
	if (!$connection){
		die(mysqli_error($mysqli));
	}

	session_start();
?>