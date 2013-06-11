<?php
include_once 'declaracio_clases.php';

error_reporting(0);

class ConexioBD
{
	public $servidor;
	public $baseDeDades;
	public $usuari;
	public $contrasenya;
	public $connexio;
	
	public function __construct($servidor, $baseDeDades, $usuari, $contrasenya)
	{
		$this->servidor = $servidor;
		$this->baseDeDades = $baseDeDades;
		$this->usuari = $usuari;
		$this->contrasenya = $contrasenya;
	}
	
	public function obrirConnexio()
	{
		$this->connexio = mysqli_connect($this->servidor, $this->usuari, $this->contrasenya);
		if (!$this->connexio)
		{
			die('Error: No es pot connectar al servidor: '.mysqli_error());
		}
		$bd_seleccionada = mysqli_select_db($this->connexio,$this->baseDeDades);
		if (!$bd_seleccionada) {
			die ('Error: No es pot connectar a la base de dades: '.mysqli_error());
		}
	}
	public function tancarConnexio()
	{
		mysqli_close($this->connexio) or die("Error: no es pot tancar la connexió amb el servidor:  ".mysqli_error());
	}
}


?>