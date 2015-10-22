<?php

class Quarto_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
	
	public function getQuartosDisponiveisTipoReserva($tipoReserva = 0){
		$filter = ($tipoReserva)?"and p.tp_modo_reserva =". $tipoReserva:"";
		$sql ="select q.* from quarto q 
				left join reserva r on r.id_quarto = q.id_quarto
				left join perfil p on p.id_perfil = q.id_perfil
				where r.id_situacao in (2,3,4) or r.id_reserva is null
				".$filter;
		return $this->db->query($sql);
	}
	
}

?>
