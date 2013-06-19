<?php
	session_start();
	session_destroy();
	echo '<meta http-equiv="Refresh" content="0; URL=../index.php"/>';
	
	/*
	 * Aquest arxiu és l'encarregat de tancar sessió. He fet un arxiu a part per utilitzar el mínim de Javascript possible i fer més amb php.
	 */
	
?>