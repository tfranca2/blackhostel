<?php
public class Cliente {

	private $id_cliente;
	private $cliente;
	private $rg;
	private $cpf;
	private $sexo;

	public function __construct ( ) { }

	public function getId_cliente ( ) { return $this->id_cliente; }
	public function getCliente ( ) { return $this->cliente; }
	public function getRg ( ) { return $this->rg; }
	public function getCpf ( ) { return $this->cpf; }
	public function getSexo( ) { return $this->sexo; }

	public function setId_cliente ( $id_cliente ) { $this->id_cliente = $id_cliente; }
	public function setCliente ( $cliente ) { $this->cliente = $cliente; }
	public function setRg ( $rg ) { $this->rg = $rg; }
	public function setCpf ( $cpf ) { $this->cpf = $cpf; }
	public function setSexo ( $sexo ) { $this->sexo = $sexo; }

}
?>