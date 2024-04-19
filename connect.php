<?php
	$connection = new mysqli('localhost', 'root', '', 'dbcatubigf2');
	
	if (!$connection){
		die(mysqli_error($mysqli));
	}

	session_start();
?>