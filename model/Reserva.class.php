<?php
public class Reserva {

	private $id_reserva;
	private $id_quarto;
	private $id_cliente;
	private $time_entrada;
	private $time_saida;
	private $id_situacao;
	private $quantidade_pessoas;
	
	public function __construct ( ) { }

	public function getId_reserva ( ) { return $this->id_reserva; }
	public function getId_quarto ( ) { return $this->id_quarto; }
	public function getId_cliente ( ) { return $this->id_cliente; }
	public function getTime_entrada ( ) { return $this->time_entrada; }
	public function getTime_saida ( ) { return $this->time_saida; }
	public function getId_situacao ( ) { return $this->id_situacao; }
	public function getQuantidade_pessoas ( ) { return $this->quantidade_pessoas; }

	public function setId_reserva ( $id_reserva ) { return $this->id_reserva = $id_reserva; }
	public function setId_quarto ( $id_quarto ) { return $this->id_quarto = $id_quarto; }
	public function setId_cliente ( $id_cliente ) { return $this->id_cliente = $id_cliente; }
	public function setTime_entrada ( $time_entrada ) { return $this->time_entrada = $time_entrada; }
	public function setTime_saida ( $time_saida ) { return $this->time_saida = $time_saida; }
	public function setId_situacao ( $id_situacao ) { return $this->id_situacao = $id_situacao; }
	public function setQuantidade_pessoas ( $quantidade_pessoas ) { return $this->quantidade_pessoas = $quantidade_pessoas; }

}
?>