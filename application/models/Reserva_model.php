<?php

class Reserva_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
	
	public function getReservas(){
		return $this->db->query("select r.*, q.id_quarto, q.numero, q.descricao ds_quarto, p.* from reserva r 
						inner join quarto q on r.id_quarto = q.id_quarto
						inner join perfil p on p.id_perfil = q.id_perfil");
	}
	
	public function getFullCurrentReservation($id){
		$id = (int) $id;
		$sql = "select r.*, q.id_quarto, q.numero, q.descricao ds_quarto, p.* from quarto q 
				left join reserva r on r.id_quarto = q.id_quarto
				left join perfil p on p.id_perfil = q.id_perfil
				where r.id_reserva = ".$id;
				
		return $this->db->query($sql)->row();
	}
	
}

?>
