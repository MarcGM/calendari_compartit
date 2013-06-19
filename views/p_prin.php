<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<!-- 
	Aquest fitxer és el que s'encarega de mostrar tota la pàgina de calendari (amb els seus links, divs, links, etc.).
	També s'encarega de cridar el codi javascript per afegir tasques, etc.
-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="StyleSheet" href="../media/estils/estils_pPrin.css" type="text/css">
		
		<title>Calendari compartit - Pàgina principal</title>
		<script type="text/javascript" src="../scripts/scripts.js"></script>
		<?php
		include_once '/htdocs/public/www/cirvianum/mGrandio/controllers/declaracio_clases.php';
		
		error_reporting(0);
		?>
		<title>UF3_Pt1_ex5</title>
	</head>
	<?php
	if(isset($_SESSION['idUsuariLoguejat'])){
		$calend_1 = new Calendari();
		//Comprova si el usuari s'acaba de logejar o bé de una altra pàgina per enstalviar-nos unes funcions o no.
		if($_SESSION['acabatDeLoguejar'] == true){
			$_SESSION['mesVisible'] = $calend_1->getMesActualNum();
			$_SESSION['anyVisible'] = $calend_1->anyActualNum;
			$_SESSION['acabatDeLoguejar'] = false;
			$_SESSION['mesCasellaActualNomMes'] = $calend_1->getMesVisibleNom();
		}
	?>
	<body>
		<div id="link_anarMesActual"> <a href="../controllers/p_anarMesActual.php">ANAR AL MES I ANY ACTUALS</a> </div>
		<div id="div_nomUsuari"><?php echo $_SESSION['idUsuariLoguejat'] ?></div>
		<div id="link_tancarSessio"> (<a href="../controllers/p_tancarSessio.php">TANCAR SESSIÓ</a>) </div>
		
		<div id="fletxaMesAnterior">
			<a href="../controllers/anarMesAnterior.php"> <<< </a>
		</div>
		<div id="fletxaMesSeguent">
			<a href="../controllers/anarMesSeguent.php"> >>> </a>
		</div>
		
		<div id="div_taulaMes">
			
			<div id="nomMesIAny">
			<?php
			//Es mostra el nom actual del més i el del any.
				echo $calend_1->getMesVisibleNom()." DEL ".$_SESSION['anyVisible'];
			?>
			</div>
			<!-- Div on estarà ubicat el formulari per a crear events. -->
			<div id="divRequadreAfegirTasca">
				<div id="titol_RequadreAfegirTasca"> </div>
				<div id="div_form_RequadreAfegirTasca">
					<div id="camps_nomTasca">
						<label>Nom</label>
						<input type="text" id="input_nomTasca" name="input_nomTasca" />
					</div>
					<!-- Aquest és el "div" de "afegir tasques." -->
					<div id="camps_hora">
						<label>Hora</label>
						<select id="select_hores">
							<?php
							for($cont = 0; $cont<24; $cont++){
								if($cont > 9){
									$contMostrar = (string)$cont;
								}else{
									$contMostrar = "0".$cont;
								}
								echo '<option id="idHora_'.$cont.'">'.$contMostrar.'</option>';
							}
							?>
						</select>
						:
						<select id="select_minuts">
							<?php
							for($cont = 0; $cont<60; $cont++){
								if($cont > 9){
									$contMostrar = (string)$cont;
								}else{
									$contMostrar = "0".$cont;
								}
								echo '<option id="idMinut_'.$cont.'">'.$contMostrar.'</option>';
							}
							?>
						</select>
					</div>
					<div id="camps_descripcio">
						<label>Descripció</label>
						<textarea id="textArea_Descripcio" maxlength="100" cols="35" rows="2"> </textarea>
					</div>
					<div id="camps_compartirEvent">
						<label>Compartir event?</label>
						<input id="inputCheckbox_compartirEvent" type="checkbox" />
					</div>
					<div id="botonsAccions">
						<button id="botoCrearTasca" onclick="click_botoCrearTasca(input_nomTasca.value,select_hores.value,select_minuts.value,textArea_Descripcio.value,inputCheckbox_compartirEvent.checked,<?php echo $_SESSION['mesVisible'] ?>,'<?php echo $_SESSION['idUsuariLoguejat'] ?>' )">Crear tasca</button>
						<button id="botoCancelarTasca" onclick="click_botoCancelarTasca()">Cancelar tasca</button>
					</div>
				</div>
			</div>
			<!-- Emergent de missatge de confirmació de dades inserides correctament. -->
			<div id="emergentMissatgeDades">
				<div id="titolEmergentMissatgeDades">Les dades s'han inserit correctament a la base de dades!</div>
				<div id="iconeEmergentMissatgeDades"> </div>
				<div id="iconeTancaremergentMissatgeDades" onclick="tancaremergentMissatgeDades();">X</div>
			</div>
			<!-- En aquest emergent anirà les tasques de cada dia. -->
			<div id="emergentInfoTasques"> </div>
			
			<table id="table_Mes">
				<tr id="titols_dies_setmana">
					<td class="titol_diaSetmana">Diluns</td>
					<td class="titol_diaSetmana">Dimarts</td>
					<td class="titol_diaSetmana">Dimecres</td>
					<td class="titol_diaSetmana">Dijous</td>
					<td class="titol_diaSetmana">Divendres</td>
					<td class="titol_diaSetmana">Dissabte</td>
					<td class="titol_diaSetmana">Diumenje</td>
				</tr>
				<?php
				/*
				 * Script PHP per a la generació de la taula html que farà de calendari.
				 */
				$cont_caselles = 1;
				//Generació de les files del calendari.
				for($cont_fila = 0; $cont_fila < 6; $cont_fila++){
				?>
					<tr id="mes_Fila_<?php echo $cont_fila + 1; ?>">
						<?php
						//Generació de les columnes de la taula de calendari.
						for($cont_columna = 0; $cont_columna < 7; $cont_columna++){
						?>
						<td id="mes_F<?php echo $cont_fila + 1; ?>C<?php echo $cont_columna + 1; ?>">
							<?php
							$sumaFila = $cont_fila + 1;
							$sumaColumna = $cont_columna + 1;
							$idCela = "mes_F".$sumaFila."C".$sumaColumna;
							?>
							<!-- Aquí anirà el número de dia. -->
							<div class="espaiNumCeles">
								<?php
								$requadreCasellaActual = $calend_1->comprovarNum1($cont_caselles);
								//Aquest "echo" mostra el número de dia segons el mes.
								echo $requadreCasellaActual; 
								
								if($requadreCasellaActual != ""){
									$diaCasellaActualMes = $requadreCasellaActual;
									$mesCasellaActualMes = $_SESSION['mesVisible'];
									$anyCasellesActualMes = $_SESSION['anyVisible'];
									
									if($calend_1->getDiaActualNum() == $diaCasellaActualMes && $calend_1->getMesActualNum() == $mesCasellaActualMes && $calend_1->getAnyActualNum() == $anyCasellesActualMes){
										echo '<script type="text/javascript">pintarCelaDiaActual("'.$idCela.'");</script>';
									}									
								}
								?>
							</div>
							<?php
							if($requadreCasellaActual != ""){
								$mesCasellaActualMesNom = $calend_1->getMesVisibleNom();
								$usuariLogejat = $_SESSION['idUsuariLoguejat'];
								
								$numeroTasquesCasellaActual = $calend_1->getNumeroTasquesCasellaActual($diaCasellaActualMes,$_SESSION['mesVisible'],$anyCasellesActualMes,$_SESSION['idUsuariLoguejat']);
								//Opcions de "veure tasques" i "afegir tasques" i els els mètodes.
								echo '<div class="divNumeroTasques" onclick="metode_veureTasques('.$diaCasellaActualMes.', \''.$_SESSION['mesVisible'].'\', '.$anyCasellesActualMes.', \''.$usuariLogejat.'\')"><u>'.$numeroTasquesCasellaActual.'</u> tasca/ques</div>';
								echo '<div class="divAfegirTasca" onclick="metode_afegirTasca('.$diaCasellaActualMes.', \''.$mesCasellaActualMesNom.'\', '.$anyCasellesActualMes.')">+</div>';
							}
							?>
						</td>
						<?php
						$cont_caselles++;
						}
						?>
					</tr>
				<?php
				}
				?>
			</table>
		</div>
	</body>
	<?php
	}else{
		//Si s'intenta entrar a la pàgina sense estar logat t'envia al index i no et deixa passar.
		echo '<meta http-equiv="Refresh" content="0; URL=../index.php"/>';
	}
	?>
</html>