<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends CI_Controller {

	const EM_USO = 1;
	const RESERVADO = 2;
	const MANUTENCAO = 3;
	const FINALIZADO = 4;
	const FECHADO = 5;
	const CANCELADO = 6;

	public function __construct(){
		parent::__construct();
		$this->load->model('Login_model','login');
		$this->login->authorize();
		$this->load->helper(array('url','form','array','app','date'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Quarto_model','quarto');
		$this->load->model('Reserva_model','reserva'); 
    }
	 
	public function index(){
		$this->load->view('index', array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'searching'
					,'tabledata'=>$this->reserva->getReservas()->result()
				));
	}
	
	public function searching(){
		
		$this->load->view('index',array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'searching'
					,'tabledata'=>$this->reserva->getReservas($this->input->post('id_sit'))->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'inserting'
					,'clientes'=>$this->db->get('cliente')->result()
					));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_reserva');
		$reserva = $this->reserva->getFullCurrentReservation($id);
		$quartos = $this->quarto->getAvailableBadroomsForEdition($reserva->tp_modo_reserva, $id, $reserva->entrada, $reserva->saida);
		$clientes = $this->db->get('cliente')->result();
		if($id){
			$this->load->view('index', array(
						'page'=>'reserva'
						,'title'=> 'Reservas'
						,'part' => 'editing'
						,'reserva'=> $reserva
						,'quartos'=> $quartos
						,'clientes'=>$clientes));
		}else{
			$this->searching();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_reserva');
		$reserva = $this->reserva->getFullCurrentReservation( $id);
	
		$quartos = $this->quarto->getAvailableBadroomsForEdition($reserva->tp_modo_reserva, $id, $reserva->entrada, $reserva->saida);
		if($id){
			$this->load->view('index', array(
						'page'=>'reserva'
						,'title'=> 'Reservas'
						,'part' => 'deleting'
						,'quartos'=> $quartos
						,'reserva'=> $reserva));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		$this->form_validation->set_rules('entrada', 'Entrada', 'required');
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('id_quarto','entrada','saida','id_cliente','qt_pessoas'),$this->input->post());
			
			$dados['entrada'] = dateTimeToUs($dados['entrada']);
			$dados['saida'] = dateTimeToUs($dados['saida']);
			$dados['id_situacao'] =self::RESERVADO;
			$this->db->insert('reserva', $dados); 
			
			$this->load->view('index',array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Reserva registrada com sucesso.');
			redirect('/reserva');
			
		}else{
			$this->searching();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			$id = $this->input->post('id_reserva');
			$reserva = $this->reserva->getFullCurrentReservation($id);
			
			$dados = elements(array('id_quarto','id_situacao','entrada','saida','id_cliente','qt_pessoas'),$this->input->post());
			if($reserva->id_situacao == 2){
				$dados['entrada'] = dateTimeToUs($dados['entrada']);
				$dados['saida'] = dateTimeToUs($dados['saida']);
			}else{
				unset($dados['entrada']);
				unset($dados['saida']);
			}
			
			$this->db->where('id_reserva', $id);
			$this->db->update('reserva', $dados); 
			
			$this->session->set_flashdata('msg', 'Reserva atualizada com sucesso.');
			$this->index();
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if($this->input->post('id_reserva')){
			$this->db->where('id_reserva', $this->input->post('id_reserva'));
			$this->db->delete('reserva'); 
			
			$this->session->set_flashdata('msg', 'Reserva deletada com sucesso.');
			$this->index();
		}else{
			$this->session->set_flashdata('msg', ":(");
			$this->index();
		}
		
	}
	
	private function runFormValidations(){
		
		
		$this->form_validation->set_rules('id_quarto', 'Quarto', 'required');
		
		return $this->form_validation->run();
	
	}
	
	public function quartos(){
		$entrada = dateTimeToUs( $this->input->get('entrada'));
		$saida   = dateTimeToUs( $this->input->get('saida'));
		$tipo = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		if($tipo){
			$quartos = $this->quarto->getAvailableBadroomsForEdition($tipo, $id, $entrada, $saida );
			//dump($quartos);
			echo json_encode($quartos);
		}
	}
	
	public function adicionar(){
		$dados['id_reserva'] = $this->input->post('reserva');
		$dados['id_produto'] = $this->input->post('produto');
		if(isset($dados['id_reserva']) and isset($dados['id_reserva'])){
			$this->db->insert('reserva_produto',$dados);
		}
		
	}
	
}
