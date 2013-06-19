<?php
include_once '/htdocs/public/www/cirvianum/mGrandio/controllers/declaracio_clases.php';

error_reporting(0);

/*
 * Aquesta classe s'encarrega de consultar la autentificació del usuari.
 */

class Autenticacio
{			
	public function consultarUsuariIContrasenya($usuariComprovar, $contrasenyaComprovar)
	{
		$novaConexio = new ConexioBD("hostingmysql255.nominalia.com","basvalley_com_cirvianum","MMC165_cirvianum","Cirvianum_1");
			
		$usuariLogin = $_POST['inputName_formLogin'];
		$contrasenyaLogin = $_POST['inputPassword_formLogin'];
		
		$novaConexio->obrirConnexio();
		$consultaUsuari = mysqli_query($novaConexio->connexio,"SELECT idUsuari, contrasenya FROM usuaris_MarcGM WHERE idUsuari = '$usuariLogin' AND contrasenya = '$contrasenyaLogin'")
			or die("Ha fallat la consulta: ".mysql_error());
		$novaConexio->tancarConnexio();
		
		if(mysqli_num_rows($consultaUsuari) != 0){
			return true;
		}else{
			return false;
		}
	}
}


?>