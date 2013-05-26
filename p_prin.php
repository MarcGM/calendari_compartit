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
				<?php
				echo "<h2>$diaCasellaActualMes de ".$calend_1->getMesVisibleNom()." del $anyCasellesActualMes</h2>";
				?>
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
								//Aquest "echo" mostra el número de dia segons el mes.
								echo $requadreCasellaActual = $calend_1->comprovarNum1($cont_caselles); 
								
								if($requadreCasellaActual != ""){
									$diaCasellaActualMes = $requadreCasellaActual;
									$mesCasellaActualMes = $_SESSION['mesVisible'];
									$anyCasellesActualMes = $_SESSION['anyVisible'];
								}
								?>
							</div>
							<?php
							if($requadreCasellaActual != ""){
								?>
								<div class="divAfegirTasca" onclick="metode_afegirTasca($diaCasellaActualMes, $mesCasellaActualMes, $anyCasellesActualMes)">+</div>
								<?php
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