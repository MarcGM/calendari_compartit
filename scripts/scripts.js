/**
 * @author Marc Grandio
 */

/*
 * Arxiu que conté tot el codi Javscript de la aplicació web.
 */

var diaAfegirTasca = null;
var anyAfegirTasca = null;

//Funció que fà apareixer el requadre per a afegir tasques.
function metode_afegirTasca(dia,mes,any){
	document.getElementById('titol_RequadreAfegirTasca').innerHTML+="<h2>"+dia+" de "+mes+" del "+any+"</h2>";
	document.getElementById('divRequadreAfegirTasca').style.display="block";
	
	diaAfegirTasca = dia;
	anyAfegirTasca = any;
}
//Funció que fà desapareixer el recuadre per afegir tasques i reinicialitza tots els camps del formulari si han estat modificats.
function click_botoCancelarTasca(){
	document.getElementById('divRequadreAfegirTasca').style.display = "none";
	document.getElementById('titol_RequadreAfegirTasca').innerHTML = "";
	document.getElementById('input_nomTasca').value = "";
	document.getElementById('select_hores').value = "00";
	document.getElementById('select_minuts').value = "00";
	document.getElementById('textArea_Descripcio').value = "";
	document.getElementById('inputCheckbox_compartirEvent').checked = 0;
}
//Comprova si el camp requerit (el nom) està complert.
function click_botoCrearTasca(nomTasca,select_hores,select_minuts,textArea_Descripcio,Checkbox_compartirEvent,mesAfegirTasca,usuariLoguejat){
	//Comprovar si els camps requerits estan omplerts.
	if(document.getElementById('input_nomTasca').value == null){
		alert('El nom és obligatori!!!');
	}else{
		inserirDadesBD(nomTasca,select_hores,select_minuts,textArea_Descripcio,Checkbox_compartirEvent,diaAfegirTasca,mesAfegirTasca,anyAfegirTasca,usuariLoguejat);
	}
}
//Funció que rep les dades del formulari i les codifica en format JSON. També rep el resulta un cop fet to el procés.
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
	//S'envien les dades en format JSON a aquesta funció que és l'encaregada de fer l'enviament.
	dadesDecodificades = enviarDadesServidor(dadesTascaStringJSON,"../controllers/afegirTascaCalendari.php");;
	//Agafa la posició associativa "resultat" del array associatiu.
	resultat = dadesDecodificades["resultat"];
	mostrarMissatges(resultat);
}
//És la funció encaregad de enviar les dades al servidor mitjançant AJAX i després de rebre el resultat.
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
//Funció que mostra un missatge al usuri segons si s'han inserit corectament o no, les dades.
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
//Funció encarregada de marcar la cel·la coresponent al dia actual.
function pintarCelaDiaActual(idCela){
	document.getElementById(idCela).style.backgroundColor = "#D0FA58";
}
//Funció encarregad de enviar i rebre informació sobre les tasques que hi ha a cada dia.
function metode_veureTasques(dia,mes,any,usuari){

	dadesTasca = {
		"dia": dia,
		"mes": mes,
		"any": any,
		"usuari": usuari,
		"accio": "veureTasques"
	};
	var dadesTascaStringJSON = JSON.stringify(dadesTasca);
	//Un cop retornades les dades des de la funció "enviarDadesServidor()", la variable "resultat" conté un array on a cada posició hi ha un objecte (que fà referència a cadascuna de les files dretornades de la consulta SQL).
	var resultat = enviarDadesServidor(dadesTascaStringJSON,"../controllers/afegirTascaCalendari.php");
	
	crearTaulaTasques(resultat,dia,mes,any);
}
//Funció encaregada de crear la taula de les tasques a un "div" del document html.
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
//Funció encarregada de tancar el emrgent que mostra el missatge dient que s'han inserit correctament o no, les dades.
function tancaremergentMissatgeDades(){
	click_botoCancelarTasca();
	document.getElementById('emergentMissatgeDades').style.display="none";
}
//Funció encarregada de tancar el emergent on es veuen les tasques de un dia en concret.
function tancarEmergentVeureTasques(){
	document.getElementById('emergentInfoTasques').style.display="none";
}
//Funció encarregad de marcar una tasca com a realitzada.
function marcarTascaRealitzada(idTascaAMarcar){
	document.getElementById(idTascaAMarcar).checked = true;
	document.getElementById(idTascaAMarcar).disabled = true;
}
