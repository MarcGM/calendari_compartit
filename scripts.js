/**
 * @author Marc Grandio
 */


function metode_afegirTasca(dia,mes,any)
{
	document.getElementById('divRequadreAfegirTasca').innerHTML+="<h2>"+dia+" de "+mes+" del "+any+"</h2>";
	document.getElementById('divRequadreAfegirTasca').style.display="block";
}
