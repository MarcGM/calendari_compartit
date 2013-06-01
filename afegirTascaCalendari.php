<?php
	include_once 'declaracio_clases.php';
	//error_reporting(0);


	//ACABAR!!!
	$dadesNovaTasca = $_POST['dadesTasca'];	
	$arrayDades = json_decode($dadesNovaTasca,true);
	//$novaConexio = new ConexioBD("localhost","uf3_pt2","usuari","contrasenya");
	//$novaConexio->obrirConnexio();
	
	$result = convertirADate($arrayDades['diaTasca'],$arrayDades['mesTasca'],$arrayDades['anyTasca'],$arrayDades['hora'],$arrayDades['minut']);
	//$ambExit = afegirTasca($novaConexio,$arrayDades['nom_tasca'],$arrayDades['hora'],$arrayDades['minut'],$arrayDades['descripcio'],$arrayDades['compartir'],$arrayDades['diaTasca'],$arrayDades['mesTasca'],$arrayDades['anyTasca']);
	echo $result;
	
	function convertirADate($diaTasca,$mesTasca,$anyTasca,$horaTasca,$minutTasca){
		$cadenaPerInserirMySQL = date("Y-m-d H:i:s", mktime((int)$horaTasca,(int)$minutTasca,0,(int)$mesTasca,(int)$diaTasca,(int)$anyTasca));
		//echo $cadenaPerInserirMySQL;
		return $cadenaPerInserirMySQL;
	}
	
	//function afegirTasca($cone)
	
?>