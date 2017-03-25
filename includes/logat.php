<?php	session_start();
	if ($_SESSION["correu"]=="") {
		header("Location:login.php");
	} ?>