<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="StyleSheet" href="estils__p_registre.css" type="text/css">
		
		<title>Trivial - Registre</title>
		
		<?php 
		include_once 'declaracio_clases.php';
		
		//error_reporting(0);
		?>
	</head>
	<body>
		<?php
		if(empty($_POST)){ ?>
		<div id="div_formRegistre">
			<form action="p_registre.php" method="post" id="formRegistre" name="formRegistre">
				Nom de usuari: <input type="text" id="inputName_formLogin" name="inputName_formLogin" required="required"/>
				<br /><br />
				Contrasenya: <input type="password" id="inputPassword_formLogin" name="inputPassword_formLogin" required="required" />
				<br /><br />
				Nom: <input type="text" id="inputNom_formLogin" name="inputNom_formLogin" required="required" />
				<br /><br />
				Cognom: <input type="text" id="inputCognom_formLogin" name="inputCognom_formLogin" required="required" />
				<br />
				<br /><br />
				<input type="submit" value="Registrar" />
			</form>
			<br /><br />
		</div>
		<div id="div_tornarPagPrin"><a href="p_prin.php">TORNAR A LA PÀGINA DE LOGIN</a></div>
		<?php 
		}else{
			$novaConexio = new ConexioBD("localhost","uf3_pt2","usuari","contrasenya");
			$novaConexio->obrirConnexio();
			
			$usuariRegistre = $_POST['inputName_formLogin'];
			$contrasenyaRegistre = $_POST['inputPassword_formLogin'];
			$nomRegistre = $_POST['inputNom_formLogin'];
			$cognomRegistre = $_POST['inputCognom_formLogin'];
			
			$registreUsuari = mysqli_query($novaConexio->connexio,"INSERT INTO usuaris_MarcGM (idUsuari, contrasenya, nom, cognom) VALUES ('$usuariRegistre','$contrasenyaRegistre','$nomRegistre','$cognomRegistre')");
			$novaConexio->tancarConnexio();
			if($registreUsuari){
				echo "Registrat correctament";
				echo '<meta http-equiv="Refresh" content="3; URL=p_prin.php"/>';
			}else{
				echo "Ha fallat la consulta de registre: ".mysql_error();
			}
		}
		?>
	</body>
</html>