<?php

class Quarto_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
	
	public function getQuartosDisponiveisTipoReserva($tipoReserva = 0, $entrada, $saida){
	
		$filter = ($tipoReserva)?"and p.tp_modo_reserva =". $tipoReserva:"";
		if($tipoReserva ==1){
			$filter .=" and (r.entrada is null or r.entrada not between '".$entrada."' and '".$saida."') 
						and (r.saida is null or r.saida not between '".$entrada."' and '".$saida."')";
		}
		
		$sql ="select distinct q.* from quarto q 
				left join reserva r on r.id_quarto = q.id_quarto
				left join perfil p on p.id_perfil = q.id_perfil
				where (r.id_situacao in (2,3,4) or r.id_reserva is null)
				".$filter;
			 
		return $this->db->query($sql);
	}
	
	
	public function getAvailableBadroomsForEdition( $tipoReserva = 0, $idCurrentReservation, $entrada, $saida){

		$quartos = $this->getQuartosDisponiveisTipoReserva($tipoReserva, $entrada, $saida)->result();

		$sql = "select q.* from quarto q 
				left join reserva r on r.id_quarto = q.id_quarto
				left join perfil p on p.id_perfil = q.id_perfil
				where r.id_reserva = ".$idCurrentReservation ." and p.tp_modo_reserva = ".$tipoReserva ;
		
		
		$currentReservedRoom = $this->db->query($sql)->row();
	
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
