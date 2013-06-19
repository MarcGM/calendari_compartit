<?php
	include_once '/htdocs/public/www/cirvianum/mGrandio/controllers/declaracio_clases.php';
	error_reporting(0);

/*
 * Aquest fitxer és l'encarregat de afegir les tasques a la base de dades i mostrar-les quan el usuari ho vol fer.
 * Les dades li arriben mitjançant AJAX i en format JSON i un cop procesades retorna una resposta al client.
 */

	$dadesNovaTasca = $_POST['dadesTasca'];
	//Aquesta funcó és l'encaregada de descodificar les dades de format JSON a un array en format php.
	$arrayDades = json_decode($dadesNovaTasca,true);
	
	//En aquest arxiu es fan dues tasques. Per saber quina métodes s'han de cridar, primer s'ha de saber quina ació vol realitzar el client.
	//Per saber-ho, s'agafa el paràmetre "accio" passat en JSON i fer una o una altra cosa.
	if($arrayDades['accio'] == "inserirDadesBD"){
		$dataConvertidaIJunta = convertirADate($arrayDades['diaTasca'],$arrayDades['mesTasca'],$arrayDades['anyTasca'],$arrayDades['hora'],$arrayDades['minut']);
		$conexio = new ConexioBD("hostingmysql255.nominalia.com","basvalley_com_cirvianum","MMC165_cirvianum","Cirvianum_1");
		$conexio->obrirConnexio();
		$connexio = $conexio->connexio;
		$ambExit = afegirTasca($connexio,$arrayDades['nom_tasca'],$arrayDades['descripcio'],$arrayDades['compartir'],$dataConvertidaIJunta,$arrayDades['usuariTasca']);
		$conexio->tancarConnexio();
		
		$resultat["resultat"] = $ambExit;
		//Codifica el array ph resultant en format JSON.
		$resultatJSON = json_encode($resultat);
	
		echo $resultatJSON;
	}else if($arrayDades['accio'] == "veureTasques"){
		$dataIniciConvertidaIJunta = convertirADate($arrayDades['dia'],$arrayDades['mes'],$arrayDades['any'],0,0);
		$dataFiConvertidaIJunta = convertirADate($arrayDades['dia'],$arrayDades['mes'],$arrayDades['any'],23,59);
		$tasques = veureTasques($dataIniciConvertidaIJunta,$dataFiConvertidaIJunta,$arrayDades['usuari']);
		//codifica el aray retornat a format JSON.
		$resultat = json_encode($tasques);
		
		echo $resultat;
	}
	//Aquesta funció s'encarega de formatar una data a format SQL per després guardar-la amb aquest format a la base de dades.
	function convertirADate($diaTasca,$mesTasca,$anyTasca,$horaTasca,$minutTasca){
		$cadenaPerInserirMySQL = date("Y-m-d H:i:s", mktime((int)$horaTasca,(int)$minutTasca,0,(int)$mesTasca,(int)$diaTasca,(int)$anyTasca));
		
		return $cadenaPerInserirMySQL;
	}
	//Inserta les dades de les tasques a la base de dades i retorna un resultat (segons si s'han inserit correctament o no.)
	function afegirTasca($connexio,$nomTasca,$descripcioTasca,$compartirTasca,$dataConvertida,$usuariTasca){
		$insertTasca = mysqli_query($connexio,"INSERT INTO tasques(nomTasca,descripcioTasca,dataTasca,compartida,idUsuari) VALUES('".$nomTasca."', '".$descripcioTasca."', '".$dataConvertida."', '".$compartirTasca."', '".$usuariTasca."');");
		if (!$insertTasca) {
			$operacioAmbExit = "false";
		}else{
			$operacioAmbExit = "true";
		}
		
		return $insertTasca;
	}
	//Fà un select de les tasques. Després aquestes es guarden en un array per més tard codificar-les en format JSON i enviar-les al client.
	function veureTasques($dataInici,$dataFi,$usuari){
		$conexio = new ConexioBD("hostingmysql255.nominalia.com","basvalley_com_cirvianum","MMC165_cirvianum","Cirvianum_1");
		$conexio->obrirConnexio();
		$connexio = $conexio->connexio;
		$consultaUsuari = mysqli_query($connexio,"SELECT * FROM tasques WHERE dataTasca >= '".$dataInici."' && dataTasca <= '".$dataFi."' && (compartida = 1 OR idUsuari = '".$usuari."')")
			or die("Ha fallat la consulta: ".mysql_error());
		$conexio->tancarConnexio();
		$files = array();
		//Possa cada cel·la del resultat de la consulta en una posicició del Array "$files".
		while($fila = mysqli_fetch_assoc($consultaUsuari)) {
		    $files[] = $fila;
		}

		return $files;
	}
	
?>