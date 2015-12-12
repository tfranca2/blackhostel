<?php

class Reserva_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->database();
		
    }
    
    public function getClientesFromReserva($id){
    	return $this->db->query("select c.cliente, c.id_cliente from reserva_cliente r inner join cliente c on r.id_cliente = c.id_cliente
    			where r.id_reserva =". $id)->result();
    }
	
	public function getReservas($situacao = 0){
		$fil = ($situacao != 0)?' and r.id_situacao ='.$situacao:'';
		if ($situacao != 6 and $situacao != 5){
			$fil .=	" and r.id_situacao not in (6, 5)";
		}
		return $this->db->query("select r.*, q.id_quarto, q.numero, p.*,c.* from reserva r 
						inner join quarto q on r.id_quarto = q.id_quarto
						inner join perfil p on p.id_perfil = q.id_perfil
						left join cliente c on c.id_cliente = r.id_cliente
						where 1=1 ".$fil."  
						order by r.id_reserva desc");
	}
	
	public function getFullCurrentReservation($id){
		$id = (int) $id;
		$sql = "select r.*, q.id_quarto, q.numero, p.*,c.* from quarto q 
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
	
	
	public function getResumoFaturamentoDia($data = ''){
		
		if($data['inicio'] != '' and $data['fim'] == '')
			$part = "month(c.data) = month('".dateTimeToUs($data['inicio']) ."')";
		elseif($data['inicio'] != '' and $data['fim'] != '')
			$part = "c.data between '".dateTimeToUs($data['inicio'])."' and '".dateTimeToUs($data['fim']) ."' ";
		else 
			$part = "month(c.data) = month(curdate())"; 
		
	$sql = 'select * from ( 
       			select c.id_caixa, date(c.data) data, c.valor  from caixa c where '. $part.' and c.operacao = 4 order by c.id_caixa desc
			) a group by date(a.data)';
		return $this->db->query($sql)->result();
	}
	
	public function getVendasProdutoDia($data = ''){
		
		if($data['inicio'] != '' and $data['fim'] == '')
			$part = "month(r.saida) = month('".dateTimeToUs($data['inicio']) ."')";
		elseif($data['inicio'] != '' and $data['fim'] != '')
			$part = "r.saida between '".dateTimeToUs($data['inicio'])."' and '".dateTimeToUs($data['fim']) ."' ";
		else 
			$part = "month(r.saida) = month(curdate())"; 
		
	$sql = 'SELECT * FROM (
				SELECT 
					DATE(r.saida) AS data
				  , p.produto
			      , count(rp.id_produto) AS quantidade 
				FROM reserva r 
				INNER JOIN reserva_produto rp ON rp.id_reserva = r.id_reserva and rp.ativo = 1
				INNER JOIN produto p ON p.id_produto = rp.id_produto 
				WHERE '.$part.' GROUP by data, rp.id_produto 
			) AS v ORDER BY v.data asc, v.quantidade DESC';
		return $this->db->query($sql)->result();
	}
	
	public function getTotalClientsPerReservation($idReserva){
		$sql = 'select (select count(id_cliente) from reserva r where r.id_reserva = '.$idReserva.'
				) + (select count(id_cliente) from reserva_cliente rc where rc.id_reserva = '.$idReserva.'  ) total';
		return $this->db->query($sql)->row();
	}
	
}

?>
