<?php
	session_start();
	include_once 'declaracio_clases.php';
	
	$calend_1 = new Calendari();
	
	if($_SESSION['mesVisible'] == 12){
		$_SESSION['mesVisible'] = 1;
		$_SESSION['anyVisible']++;
	}else{
		$_SESSION['mesVisible']++;
	}
	echo '<meta http-equiv="Refresh" content="0; URL=p_prin.php"/>';
?>