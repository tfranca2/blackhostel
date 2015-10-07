<?php

class Perfil_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
	
	public function getPrecoItensPerfil($idPerfil = 0){
		$sql ="select sum(i.preco) from perfil_item pi inner join item i on i.id_item = pi.id_item where pi.id_perfil = ?";
		$this->db->query($sql, array(1, $idPerfil));
	}
	
	public function loadPerfil(){
		$sql = "select p.id_perfil, p.descricao, p.preco_base, p.tp_modo_reserva, sum(preco) preco_itens from perfil p 
				inner join perfil_item pi on pi.id_perfil = p.id_perfil 
				inner join item i on i.id_item = pi.id_item group by p.id_perfil, p.descricao, p.preco_base, p.tp_modo_reserva";

		return $this->db->query($sql);
	}
	
	public function findPerfil($descricao = ""){
		$like = ($descricao != "")? " and p.descricao like '%".$descricao."%' ":"";
		$sql = "select p.id_perfil, p.descricao, p.preco_base, p.tp_modo_reserva, sum(preco) preco_itens from perfil p 
				inner join perfil_item pi on pi.id_perfil = p.id_perfil 
				inner join item i on i.id_item = pi.id_item
				where 1=1".$like."
				group by p.id_perfil, p.descricao, p.preco_base, p.tp_modo_reserva";

		return $this->db->query($sql);
	}
}

?>
