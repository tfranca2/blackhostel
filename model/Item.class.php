<?php
public class Item {

	private $id_item;
	private $item;
	private $indicador_calculo;

	public function __construct ( ) { }

	public function getId_item ( ) { return $this->id_item; }
	public function getItem ( ) { return $this->item; }
	public function getIndicador_calculo ( ) { return $this->indicador_calculo; }

	public function setId_item ( $id_item ) { return $this->id_item = $id_item; }
	public function setItem ( $item ) { return $this->item = $item; }
	public function setIndicador_calculo ( $indicador_calculo ) { return $this->indicador_calculo = $indicador_calculo; }

}
?>