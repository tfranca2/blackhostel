<?php

class Reserva_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
	
	public function getReservas($situacao = 0){
		$fil = ($situacao != 0)?' and r.id_situacao ='.$situacao:'';
		if ($situacao != 6 and $situacao != 5){
			$fil .=	" and r.id_situacao not in (6, 5)";
		}
		return $this->db->query("select r.*, q.id_quarto, q.numero, q.descricao ds_quarto, p.*,c.* from reserva r 
						inner join quarto q on r.id_quarto = q.id_quarto
						inner join perfil p on p.id_perfil = q.id_perfil
						left join cliente c on c.id_cliente = r.id_cliente
						where 1=1 ".$fil."  
						order by r.id_reserva desc");
	}
	
	public function getFullCurrentReservation($id){
		$id = (int) $id;
		$sql = "select r.*, q.id_quarto, q.numero, q.descricao ds_quarto, p.*,c.* from quarto q 
				left join reserva r on r.id_quarto = q.id_quarto
				left join perfil p on p.id_perfil = q.id_perfil
				left join cliente c on c.id_cliente = r.id_cliente
				where r.id_reserva = ".$id;
				
		return $this->db->query($sql)->row();
	}
	
	public function getSumReservationMonths(){
		$sql = 'select "Diária" tipo_reserva, count(EXTRACT(MONTH FROM r.entrada)) AS qtdmes, EXTRACT(MONTH FROM r.entrada)
			mes from reserva r inner join quarto q on r.id_quarto = q.id_quarto inner 
			join perfil p on p.id_perfil = q.id_perfil where p.tp_modo_reserva = 1 group by EXTRACT(MONTH FROM r.entrada)
			union 
			select "Hora" tipo_reserva, count(EXTRACT(MONTH FROM r.entrada)) AS qtdmes, EXTRACT(MONTH FROM r.entrada) 
			mes from reserva r inner join quarto q on r.id_quarto = q.id_quarto inner 
			join perfil p on p.id_perfil = q.id_perfil where p.tp_modo_reserva = 2 group by EXTRACT(MONTH FROM r.entrada)';
		return $this->db->query($sql)->result();
	}
	
}

?>
