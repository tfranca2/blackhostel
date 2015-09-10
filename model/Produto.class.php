<?php
public class Produto {

	private $id_produto;
	private $produto;
	private $preco;
	private $codigoDeBarras;

	public function __construct ( ) { }

	public function getId_produto ( ) { return $this->id_produto; }
	public function getProduto ( ) { return $this->produto; }
	public function getPreco ( ) { return $this->preco; }
	public function getCodigoDeBarras ( ) { return $this->codigoDeBarras; }

	public function setId_produto ( $id_produto ) { $this->id_produto = $id_produto; }
	public function setProduto ( $produto ) { $this->produto = $produto; }
	public function setPreco ( $preco ) { $this->preco = $preco; }
	public function setCodigoDeBarras ( $codigoDeBarras ) { $this->codigoDeBarras = $codigoDeBarras; }

}
?>