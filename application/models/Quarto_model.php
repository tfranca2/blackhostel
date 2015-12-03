<?php

class Quarto_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
	
	public function getQuartosDisponiveisTipoReserva($tipoReserva = 0, $entrada, $saida){
		
		$reservasAtivas = $this->getReservasAtivasIntervalo($entrada, $saida, $tipoReserva);
		
		
		if(count($reservasAtivas) > 0){
			
			$quartosOcupados = "";
			
			foreach ($reservasAtivas as $ra){
				$quartosOcupados .= $ra->id_quarto.",";
			}
		
			$filter =" p.tp_modo_reserva = ".$tipoReserva." and q.id_quarto not in(". rtrim($quartosOcupados , ",") ." )";
			
		}else{
			
			$filter =" p.tp_modo_reserva = ".$tipoReserva;
		}
		
		$sql ="select q.*, p.descricao as perfil from quarto q 
				inner join perfil p on p.id_perfil = q.id_perfil
				where ". $filter;
		
		return $this->db->query($sql);
	}
	
	public function getReservasAtivasIntervalo($entrada, $saida, $tipoReserva){
		$sql= "SELECT r.* FROM reserva r
				join quarto q on r.id_quarto = q.id_quarto
				join perfil p on p.id_perfil = q.id_perfil
				where 
				(r.entrada between '".$entrada."' and '".$saida."' 
				or r.saida between '".$entrada."' and '".$saida."')
				and r.id_situacao in (1,2,3) and p.tp_modo_reserva = ". $tipoReserva;
		return $this->db->query($sql)->result();
	}
	
	public function getAvailableBadroomsForEdition( $tipoReserva = 0, $idCurrentReservation, $entrada, $saida){

		$quartos = $this->getQuartosDisponiveisTipoReserva($tipoReserva, $entrada, $saida)->result();
	
		
		if($idCurrentReservation != 0){
			$sql = "select q.*, p.descricao as perfil from quarto q 
					left join reserva r on r.id_quarto = q.id_quarto
					left join perfil p on p.id_perfil = q.id_perfil
					where r.id_reserva = ".$idCurrentReservation ." and p.tp_modo_reserva = ".$tipoReserva ;
			
			
			$currentReservedRoom = $this->db->query($sql)->row();
		}
	
		foreach($quartos as $key => $quarto){
			if( isset($currentReservedRoom) and ($quarto->id_quarto == $currentReservedRoom->id_quarto )){
				unset($quartos[$key]);
			}	
		}
		
		if(isset($currentReservedRoom))
			return array_merge($quartos, array($currentReservedRoom)); 
		else
			return $quartos;
	}	
	
}

?>
