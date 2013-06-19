<?php
	session_start();
	$_SESSION['acabatDeLoguejar'] = true;
	echo '<meta http-equiv="Refresh" content="0; URL=../views/p_prin.php"/>';
	
	/*
	 * Aquest arxiu és l'encarregat de anar al mes actual. He fet un arxiu a part per utilitzar el mínim de Javascript possible i fer més amb php.
	 */
	
?>