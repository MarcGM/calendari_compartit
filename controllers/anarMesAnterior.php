<?php
	session_start();
	include_once '/htdocs/public/www/cirvianum/mGrandio/controllers/declaracio_clases.php';
	
	$calend_1 = new Calendari();
	
	if($_SESSION['mesVisible'] == 1){
		$_SESSION['mesVisible'] = 12;
		$_SESSION['anyVisible']--;
	}else{
		$_SESSION['mesVisible']--;
	}
	echo '<meta http-equiv="Refresh" content="0; URL=../views/p_prin.php"/>';
?>