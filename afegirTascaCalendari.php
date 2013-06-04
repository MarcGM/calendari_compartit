<?php
	include_once 'declaracio_clases.php';
	//error_reporting(0);


	//ACABAR!!!
	$dadesNovaTasca = $_POST['dadesTasca'];	
	$arrayDades = json_decode($dadesNovaTasca,true);
	$dataConvertidaIJunta = convertirADate($arrayDades['diaTasca'],$arrayDades['mesTasca'],$arrayDades['anyTasca'],$arrayDades['hora'],$arrayDades['minut']);
	$conexio = new ConexioBD("127.0.0.1","uf3_pt2","usuari","contrasenya");
	$conexio->obrirConnexio();
	$connexio = $conexio->connexio;
	$ambExit = afegirTasca($connexio,$arrayDades['nom_tasca'],$arrayDades['descripcio'],$arrayDades['compartir'],$dataConvertidaIJunta,$arrayDades['usuariTasca']);
	$conexio->tancarConnexio();
	
	$resultat = Array();
	$resultat['resultat'] = $ambExit;
	$resultat = json_encode($resultat);

	echo $resultat;
	
	function convertirADate($diaTasca,$mesTasca,$anyTasca,$horaTasca,$minutTasca){
		$cadenaPerInserirMySQL = date("Y-m-d H:i:s", mktime((int)$horaTasca,(int)$minutTasca,0,(int)$mesTasca,(int)$diaTasca,(int)$anyTasca));
		
		return $cadenaPerInserirMySQL;
	}
	function afegirTasca($connexio,$nomTasca,$descripcioTasca,$compartirTasca,$dataConvertida,$usuariTasca){
		$insertTasca = mysqli_query($connexio,"INSERT INTO tasques(nomTasca,descripcioTasca,dataTasca,compartida,idUsuari) VALUES('".$nomTasca."', '".$descripcioTasca."', '".$dataConvertida."', '".$compartirTasca."', '".$usuariTasca."');");
		if (!$insertTasca) {
			$operacioAmbExit = false;
		}else{
			$operacioAmbExit = true;
		}
		return $insertTasca;
	}
	
?>