<?php
include_once 'declaracio_clases.php';

//error_reporting(0);

class Calendari
{	
	public $diesMesos = Array(12);
	public $diaActualNum;
	public $mesActualNum;
	public $anyActualNum;
	public $diesSetmana = Array();
	public $numerosGraellaMes = Array(35);
	public $mesNum;
	public $contIdsnumDies;
	public $primerCop;
	public $dia_1_possat;
	public $contador_dia_1;
	public $dia_1_diumenje_possat;
	
	public function __construct()
	{
		$this->diaActualNum = $this->getDiaActualNum();
		$this->mesActualNum = $this->getMesActualNum();
		$this->anyActualNum = $this->getAnyActualNum();
		
		$this->diesMesos[0] = 31;
		$this->diesMesos[1] = $this->calcularDiesFebrer($_SESSION['anyVisible']);
		$this->diesMesos[2] = 31;
		$this->diesMesos[3] = 30;
		$this->diesMesos[4] = 31;
		$this->diesMesos[5] = 30;
		$this->diesMesos[6] = 31;
		$this->diesMesos[7] = 31;
		$this->diesMesos[8] = 30;
		$this->diesMesos[9] = 31;
		$this->diesMesos[10] = 30;
		$this->diesMesos[11] = 31;
		
		$this->contIdsnumDies = 0;
		$this->primerCop = true;
		$this->contador_dia_1 = 0;
		$this->dia_1_possat = false;
		$this->dia_1_diumenje_possat = false;
	}
	
	public function calcularDiesFebrer($any)
	{
		if($any % 4 == 0){
			return 29;
		}else{
			return 28;
		}
	}
	
	/*
	 * Aquest mètode encara no s'ha implementat (2-4-2013):
	 */
	public function cambiarIdNumDies()
	{
		if($this->contIdsnumDies != 0 && $this->contIdsnumDies <= $this->diesMesos[$this->mesNum]){
			$valorARetornar = $this->numerosGraellaMes[$this->contIdsnumDies];
			$this->contIdsnumDies++;
			return "CD".$valorARetornar;
		}else{
			$this->contIdsnumDies++;
			return "";
		}
	}
	
	public function comprovarNum1($cont_caselles)
	{
		if($this->dia_1_possat == false){
			$dia_1 = $this->getDiaSetmanaNum(1,$_SESSION['mesVisible'],$_SESSION['anyVisible']);
			if($dia_1 == 0 && $this->dia_1_diumenje_possat == false){
				if($cont_caselles < 7){
					return "";
				}else{
					$this->dia_1_diumenje_possat == true;
					$this->dia_1_possat = true;
					$this->contador_dia_1++;
					
					return $this->contador_dia_1;
				}	
			}else{
				if($cont_caselles == $dia_1){
					$this->dia_1_possat = true;
					$this->contador_dia_1++;
					
					return $this->contador_dia_1;
				}else{
					return "";
				}
			}
		}else{
			if($this->contador_dia_1 < $this->diesMesos[$_SESSION['mesVisible'] - 1]){
				$this->contador_dia_1++;
				
				return $this->contador_dia_1;
			}else{
				return "";
			}
		}
	}
	
	public function getDiaSetmanaNum($diaNum,$mesNum,$any)
	{
		$numAData = date("w", mktime(0, 0, 0, $mesNum, $diaNum, $any));
		
		return $numAData;
	}
	public function getDiaActualNum()
	{
		$diaActualNum = getdate();
		
		return $diaActualNum[mday];
	}
	public function getMesActualNum()
	{
		$mesActualNum = getdate();
		
		return $mesActualNum[mon];
	}
	public function getMesVisibleNom()
	{
		$mesVisibleNum = $_SESSION['mesVisible'];
		$mesVisibleNoms = Array(12);
		
		$mesVisibleNoms[1] = "GENER";
		$mesVisibleNoms[2] = "FEBRER";
		$mesVisibleNoms[3] = "MARÇ";
		$mesVisibleNoms[4] = "ABRIL";
		$mesVisibleNoms[5] = "MAIG";
		$mesVisibleNoms[6] = "JUNY";
		$mesVisibleNoms[7] = "JULIOL";
		$mesVisibleNoms[8] = "AGOST";
		$mesVisibleNoms[9] = "SEPTEMBRE";
		$mesVisibleNoms[10] = "OCTUBRE";
		$mesVisibleNoms[11] = "NOVEMBRE";
		$mesVisibleNoms[12] = "DECEMBRE";
		
		return $mesVisibleNoms[$mesVisibleNum];
	}
	public function getAnyActualNum()
	{
		$anyActualNum = getdate();
		
		return $anyActualNum[year];
	}
}


?>