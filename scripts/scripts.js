/**
 * @author Marc Grandio
 */

var diaAfegirTasca = null;
var anyAfegirTasca = null;

function metode_afegirTasca(dia,mes,any){
	document.getElementById('titol_RequadreAfegirTasca').innerHTML+="<h2>"+dia+" de "+mes+" del "+any+"</h2>";
	document.getElementById('divRequadreAfegirTasca').style.display="block";
	
	diaAfegirTasca = dia;
	anyAfegirTasca = any;
}

function click_botoCancelarTasca(){
	document.getElementById('divRequadreAfegirTasca').style.display = "none";
	document.getElementById('titol_RequadreAfegirTasca').innerHTML = "";
	document.getElementById('input_nomTasca').value = "";
	document.getElementById('select_hores').value = "00";
	document.getElementById('select_minuts').value = "00";
	document.getElementById('textArea_Descripcio').value = "";
	document.getElementById('inputCheckbox_compartirEvent').checked = 0;
}
function click_botoCrearTasca(nomTasca,select_hores,select_minuts,textArea_Descripcio,Checkbox_compartirEvent,mesAfegirTasca,usuariLoguejat){
	//Comprovar si els camps requerits estan omplerts.
	if(document.getElementById('input_nomTasca').value == null){
		alert('El nom és obligatori!!!');
	}else{
		inserirDadesBD(nomTasca,select_hores,select_minuts,textArea_Descripcio,Checkbox_compartirEvent,diaAfegirTasca,mesAfegirTasca,anyAfegirTasca,usuariLoguejat);
	}
}
function inserirDadesBD(nomTasca,select_hores,select_minuts,textArea_Descripcio,Checkbox_compartirEvent,diaAfegirTasca,mesAfegirTasca,anyAfegirTasca,usuariAfegirTasca){
	
	var dadesTasca = new Array();
	var dadesDecodificades = new Array();
	var resultat;
	
	dadesTasca = {
		"nom_tasca": nomTasca,
		"hora": select_hores,
		"minut": select_minuts,
		"descripcio": textArea_Descripcio,
		"compartir": Checkbox_compartirEvent,
		"diaTasca": diaAfegirTasca,
		"mesTasca": mesAfegirTasca,
		"anyTasca": anyAfegirTasca,
		"usuariTasca": usuariAfegirTasca,
		"accio": "inserirDadesBD"
	};
	var dadesTascaStringJSON = JSON.stringify(dadesTasca);
	dadesDecodificades = enviarDadesServidor(dadesTascaStringJSON,"afegirTascaCalendari.php");;
	//Agafa la posició associativa "resultat" del array associatiu.
	resultat = dadesDecodificades["resultat"];
	mostrarMissatges(resultat);
}
function enviarDadesServidor(campsTascaJSON,arxiu){
	var xmlHttp;
	var dadesRebudes;
	var dadesDecodificades = new Array();
	
	xmlHttp = new XMLHttpRequest();
	
	xmlHttp.onreadystatechange = function()
	{
		if(xmlHttp.readyState === 4 && xmlHttp.status === 200){
			//Reb la informació (en aquest cas en format JSON).
			dadesRebudes = xmlHttp.responseText;
			//Transforma el string JSON en un array de Javascript.
			dadesDecodificades = JSON.parse(dadesRebudes);
		}
	}
	xmlHttp.open("POST",arxiu,false);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlHttp.send("dadesTasca="+campsTascaJSON);

	return dadesDecodificades;
}
function mostrarMissatges(resultat){
	if(resultat == true){
		click_botoCancelarTasca();
		//Mostra el missatge de "Insertat correctament".
		document.getElementById('titolEmergentMissatgeDades').innerHTML = "Les dades s'han inserit correctament a la base de dades!";
		document.getElementById('emergentMissatgeDades').style.display = "block";
	}else{
		click_botoCancelarTasca();
		document.getElementById('titolEmergentMissatgeDades').innerHTML = "ERROR en inserir les dades (les dades no s'han inserit corectament).<br /> Comunique-ho al administrador.";
		document.getElementById('emergentMissatgeDades').style.display = "block";
	}
}
function pintarCelaDiaActual(idCela){
	document.getElementById(idCela).style.backgroundColor = "#D0FA58";
}

function metode_veureTasques(dia,mes,any,usuari){
	//var dadesTasca = new Array();
	
	dadesTasca = {
		"dia": dia,
		"mes": mes,
		"any": any,
		"usuari": usuari,
		"accio": "veureTasques"
	};
	var dadesTascaStringJSON = JSON.stringify(dadesTasca);
	//Un cop retornades les dades des de la funció "enviarDadesServidor()", la variable "resultat" conté un array on a cada posició hi ha un objecte (que fà referència a cadascuna de les files dretornades de la consulta SQL).
	var resultat = enviarDadesServidor(dadesTascaStringJSON,"afegirTascaCalendari.php");
	
	crearTaulaTasques(resultat,dia,mes,any);
}
function crearTaulaTasques(dadesJSON,dia,mes,any){
	var htmlDadesJSON = "";
	//Aquesta variable guarda la mida del array que conté els objectes amb les dades.
	var numeroFilesArray = dadesJSON.length;

	htmlDadesJSON += '<table id="taula_dadesTasca" name="taula_dadesTasca">';
	htmlDadesJSON += '<tr><th id="titolTaulaTasques" colspan="3">TASQUES '+dia+'-'+mes+'-'+any+'<div id="botoTancarVeureTasques" onclick="tancarEmergentVeureTasques()">X</div></th></tr>';
	htmlDadesJSON += '<tr><th id="capcelera_nomTasca">Nom Tasca</th> <th id="capcelera_horaTasca">Hora</th> <th id="capcelera_realitzada">Realitzada?</th>';
	for(var cont=0; cont<numeroFilesArray; cont++){
		var idTasca = dadesJSON[cont].idTasca;
		var nomTasca = dadesJSON[cont].nomTasca;
		var tascaRealitzada = dadesJSON[cont].realitzada;
		var dataTasca = dadesJSON[cont].dataTasca;
		var dataTasca_hora = dataTasca.substring(11,16);
		var marcat = "";
		var bloquejat = "";
		
		if(tascaRealitzada == 1){
			marcat = "checked";
			bloquejat = "disabled";
			
		}
		
		htmlDadesJSON += '<tr>'
		
		htmlDadesJSON += '<td id="tdNomTasca_'+idTasca+'">'+nomTasca+'</td>';
		htmlDadesJSON += '<td id="tdDataTasca_'+idTasca+'">'+dataTasca_hora+'</td>';
		htmlDadesJSON += '<td id="tdRealitzada_'+idTasca+'"><input type="checkbox" id="checkbox_'+idTasca+'" onclick="marcarTascaRealitzada(this.id)" '+marcat+' '+bloquejat+' /></td>';
		
		htmlDadesJSON += '</tr>';
	}
	htmlDadesJSON += '</table>';
	
	document.getElementById('emergentInfoTasques').innerHTML = htmlDadesJSON;
	document.getElementById('emergentInfoTasques').style.display = "block";
}
function tancaremergentMissatgeDades(){
	click_botoCancelarTasca();
	document.getElementById('emergentMissatgeDades').style.display="none";
}
function tancarEmergentVeureTasques(){
	document.getElementById('emergentInfoTasques').style.display="none";
}
function marcarTascaRealitzada(idTascaAMarcar){
	document.getElementById(idTascaAMarcar).checked = true;
	document.getElementById(idTascaAMarcar).disabled = true;
}
