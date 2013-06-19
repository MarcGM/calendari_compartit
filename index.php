<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="background-image: url('media/img/calendariPortada.jpg')">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Calendari compartit - Login</title>
		
		<link rel="StyleSheet" href="media/estils/estils_pIndex.css" type="text/css">
		<?php 
		include_once 'declaracio_clases.php';
		
		//error_reporting(0);
		?>
	</head>
	<body>
		<?php
		if(!isset($_SESSION['idUsuariLoguejat'])){
			if(empty($_POST)){ ?>
			<div id="div_formLogin">
				<form action="index.php" method="post" id="formLogin" name="formLogin">
					Nom de usuari: <input type="text" id="inputName_formLogin" name="inputName_formLogin" />
					<br /><br />
					Contrasenya: <input type="password" id="inputPassword_formLogin" name="inputPassword_formLogin" />
					<br /><br />
					<input id= "botoLogin" type="submit" value="Entrar" />
				</form>
				<br /><br />
				<button id="enllacPagRegistre" onclick="window.location.href='p_registre.php'">Registrar-te</button>
			</div>
			<?php
			}else{
				$novaAutenticacio = new Autenticacio();
				$resultat = $novaAutenticacio->consultarUsuariIContrasenya($_POST['inputName_formLogin'],$_POST['inputPassword_formLogin']);
				if($resultat == true){
					//La autenticació és correcte. //Mostrar missatge
					//Es crea una sessió.
					$_SESSION['idUsuariLoguejat'] = $_POST['inputName_formLogin'];
					$_SESSION['passwordUsuariLoguejat'] = $_POST['inputPassword_formLogin'];
					$_SESSION['acabatDeLoguejar'] = true;
					echo '<meta http-equiv="Refresh" content="0; URL=p_prin.php"/>';
				}else{
					echo '<meta http-equiv="Refresh" content="0; URL=index.php"/>';
				}
			}
		}else{
			echo '<meta http-equiv="Refresh" content="0; URL=p_prin.php"/>';
		}
		?>
	</body>
</html>

