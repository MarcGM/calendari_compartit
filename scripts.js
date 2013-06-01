/**
 * @author Marc Grandio
 */


function metode_afegirTasca(dia,mes,any){
	document.getElementById('titol_RequadreAfegirTasca').innerHTML+="<h2>"+dia+" de "+mes+" del "+any+"</h2>";
	document.getElementById('divRequadreAfegirTasca').style.display="block";
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
function click_botoCrearTasca(nomTasca,select_hores,select_minuts,textArea_Descripcio,Checkbox_compartirEvent){
	alert(nomTasca+" "+select_hores+" "+select_minuts+" "+textArea_Descripcio+" "+Checkbox_compartirEvent);
}
function pintarCelaDiaActual(idCela){
	console.log(idCela);
	document.getElementById(idCela).style.backgroundColor = "#D0FA58";
}
