<?php
public class Quarto {
	private $id_quarto;
	private $numero;
	private $id_config_quarto;

	public function __construct ( ) { }

	public function getId_quarto ( ) { return $this->id_quarto; }
	public function getNumero ( ) { return $this->numero; }
	public function getId_config_quarto ( ) { return $this->id_config_quarto; }
	
	public function setId_quarto ( $id_quarto ) { $this->id_quarto = $id_quarto; }
	public function setNumero ( $numero) { $this->numero = $numero; }
	public function setId_config_quarto ( $id_config_quarto ) { $this->id_config_quarto = $id_config_quarto; }

}
?>