<?php
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<!-- 
	Marc Grandio
	UF3_Pt1_ex5 
-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<link rel="StyleSheet" href="estils.css" type="text/css">
		<script type="text/javascript" src="scripts.js"></script>
		<?php
		include_once 'declaracio_clases.php';
		
		//error_reporting(0);
		?>
		<title>UF3_Pt1_ex5</title>
	</head>
	<?php
	if(isset($_SESSION['idUsuariLoguejat'])){
		$calend_1 = new Calendari();
		if($_SESSION['acabatDeLoguejar'] == true){
			$_SESSION['mesVisible'] = $calend_1->getMesActualNum();
			$_SESSION['anyVisible'] = $calend_1->anyActualNum;
			$_SESSION['acabatDeLoguejar'] = false;
			$_SESSION['mesCasellaActualNomMes'] = $calend_1->getMesVisibleNom();
		}
	?>
	<body>
		<div id="link_anarMesActual"> <a href="p_anarMesActual.php">ANAR AL MES I ANY ACTUALS</a> </div>
		<div id="link_tancarSessio"> (<a href="p_tancarSessio.php">TANCAR SESSIÓ</a>) </div>
		
		<div id="fletxaMesAnterior">
			<a href="anarMesAnterior.php"> <<< </a>
		</div>
		<div id="fletxaMesSeguent">
			<a href="anarMesSeguent.php"> >>> </a>
		</div>
		
		<div id="div_taulaMes">
			
			<div id="nomMesIAny">
			<?php
				echo $calend_1->getMesVisibleNom()." DEL ".$_SESSION['anyVisible'];
			?>
			</div>
			<!-- Div on estarà ubicat el formulari per a crear events. -->
			<div id="divRequadreAfegirTasca">
				<div id="titol_RequadreAfegirTasca"> </div>
				<div id="div_form_RequadreAfegirTasca">
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
						<textarea id="textArea_Descripcio" maxlength="100" cols="35" rows="3"> </textarea>
					</div>
					<div id="camps_compartirEvent">
						<label>Compartir event?</label>
						<input id="inputCheckbox_compartirEvent" type="checkbox" />
					</div>
					<div id="botonsAccions">
						<button id"botoCrearTasca">Crear tasca</button>
						<button id"botoCancelarTasca">Cancelar tasca</button>
					</div>
				</div>
			</div>
			
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
				for($cont_fila = 0; $cont_fila < 6; $cont_fila++){
				?>
					<tr id="mes_Fila_<?php echo $cont_fila + 1; ?>">
						<?php
						for($cont_columna = 0; $cont_columna < 7; $cont_columna++){
						?>
						<td id="mes_F<?php echo $cont_fila + 1; ?>C<?php echo $cont_columna + 1; ?>">
							<div class="espaiNumCeles">
								<?php
								$requadreCasellaActual = $calend_1->comprovarNum1($cont_caselles);
								//Aquest "echo" mostra el número de dia segons el mes.
								echo $requadreCasellaActual; 
								
								if($requadreCasellaActual != ""){
									$diaCasellaActualMes = $requadreCasellaActual;
									$mesCasellaActualMes = $_SESSION['mesVisible'];
									$anyCasellesActualMes = $_SESSION['anyVisible'];
								}
								?>
							</div>
							<?php
							if($requadreCasellaActual != ""){
								$mesCasellaActualMesNom = $calend_1->getMesVisibleNom();
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
		echo '<meta http-equiv="Refresh" content="0; URL=index.php"/>';
	}
	?>
</html>