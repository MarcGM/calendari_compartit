<?php
include_once 'declaracio_clases.php';

//error_reporting(0);

class Autenticacio
{			
	public function consultarUsuariIContrasenya($usuariComprovar, $contrasenyaComprovar)
	{
		$novaConexio = new ConexioBD("127.0.0.1","uf3_pt2","usuari","contrasenya");
			
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