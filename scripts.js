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
	var resultat = new Array();
	
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
	dadesDecodificades = enviarDadesServidor(dadesTascaStringJSON,"afegirTascaCalendari.php");
	console.log(dadesDecodificades);
	//Agafa la posició associativa "resultat" del array associatiu.
	//resultat = dadesDecodificades['resultat'];
	//console.log(resultat);
	mostrarMissatges("true");
}
function enviarDadesServidor(campsTascaJSON,arxiu){
	var dadesRebudes;
	var dadesDecodificades;
	
	xmlHttp = new XMLHttpRequest();
	
	xmlHttp.open("POST",arxiu,false);
	xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlHttp.send("dadesTasca="+campsTascaJSON);
	
	xmlHttp.onreadystatechange = function()
	{
		if(xmlHttp.readyState===4 && xmlHttp.status===200){	
			//Reb la informació (en aquest cas en format JSON).
			dadesRebudes = xmlHttp.responseText;
			console.log(dadesRebudes);
			//Transforma el string JSON en un array de Javascript.
			dadesDecodificades = JSON.parse(dadesRebudes);
			console.log(dadesDecodificades);
			return dadesDecodificades;
		}
	}
}
function mostrarMissatges(resultat){
	if(resultat == "true"){
		click_botoCancelarTasca();
		//Mostra el missatge de "Insertat correctament".
		document.getElementById('emergentMissatgeDadesCorrectes').style.display="block";
	}else{
		click_botoCancelarTasca();
		//Mostra un missatge de "No s'ha pogut inserir".
		
	}
}
function pintarCelaDiaActual(idCela){
	console.log(idCela);
	document.getElementById(idCela).style.backgroundColor = "#D0FA58";
}

function metode_veureTasques(dia,mes,any,usuari){
	var dadesTasca = new Array();
	
	dadesTasca = {
		"dia": dia,
		"mes": mes,
		"any": any,
		"usuari": usuari,
		"accio": "veureTasques"
	};
	var dadesTascaStringJSON = JSON.stringify(dadesTasca);
	var resultat = enviarDadesServidor(dadesTascaStringJSON,"afegirTascaCalendari.php");
	//Acció que es farà amb les dades rebudes "resultat".
}
function tancaremergentMissatgeDadesCorrectes(){
	click_botoCancelarTasca();
	document.getElementById('emergentMissatgeDadesCorrectes').style.display="none";
}
