<?php

class Reserva_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
	
	public function getReservas(){
		return $this->db->query("select * from reserva r 
						inner join quarto q on r.id_quarto = q.id_quarto
						inner join perfil p on p.id_perfil = q.id_perfil");
	}
	
}

?>
