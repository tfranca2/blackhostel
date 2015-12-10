<?php

class Comanda_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
	
	public function getResumoReserva($idReserva){
	
		$sql = "SELECT 
					TIMESTAMPDIFF( DAY, re.entrada, re.saida ) AS dias 
					,TIMESTAMPDIFF( HOUR, re.entrada, re.saida ) AS horas
					,TIMESTAMPDIFF( HOUR, re.entrada + INTERVAL TIMESTAMPDIFF(DAY,  re.entrada, re.saida) DAY, re.saida ) AS horaDia
					,TIMESTAMPDIFF( MINUTE, re.entrada + INTERVAL TIMESTAMPDIFF(HOUR,  re.entrada, re.saida) HOUR, re.saida ) AS minutos
					,pf.tp_modo_reserva AS tipo 
					,pf.preco_base AS valor_perfil  
					,(SELECT SUM(it.preco) FROM perfil_item pit LEFT JOIN item it ON pit.id_item = it.id_item WHERE pf.id_perfil = pit.id_perfil AND pf.id_perfil = qt.id_perfil) AS valor_itens
					,(SELECT SUM(pt.preco) FROM reserva_produto rpt  LEFT JOIN produto pt ON rpt.id_produto = pt.id_produto and rpt.ativo = 1	WHERE re.id_reserva = rpt.id_reserva) AS valor_produtos
          			,pf.id_perfil
					FROM reserva re
					LEFT JOIN cliente cl ON re.id_cliente = cl.id_cliente
					LEFT JOIN quarto qt ON re.id_quarto = qt.id_quarto
					LEFT JOIN perfil pf ON qt.id_perfil = pf.id_perfil
					LEFT JOIN perfil_preco pfp ON pfp.id_perfil = pf.id_perfil
				WHERE 1 = 1 AND re.id_reserva =".$idReserva;
				
		return $this->db->query($sql)->row();
			 
	}
	
	
}

?>
