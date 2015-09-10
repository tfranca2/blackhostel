<?php
public class Situacao_reserva {

	private $id_situacao;
	private $situacao;
	
	public function __construct ( ) { }

	public function getId_situacao( ) { return $this->id_situacao; }
	public function getSituacao( ) { return $this->situacao; }

	public function setId_situacao ( $id_situacao ) { return $this->id_situacao = $id_situacao; }
	public function setSituacao ( $situacao ) { return $this->situacao = $situacao; }

}
?>