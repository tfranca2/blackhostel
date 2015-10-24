<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends CI_Controller {

	const EM_USO = 1;
	const RESERVADO = 2;
	const LIVRE = 3;
	const MANUTENCAO = 4;

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app','date'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Login_model','login');
		$this->load->model('Quarto_model','quarto');
		$this->load->model('Reserva_model','reserva'); 
		$this->login->authorize();
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
					,'tabledata'=>$this->reserva->getReservas()->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'inserting'
					));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_reserva');
		$reserva = $this->reserva->getFullCurrentReservation( $id);
		$quartos = $this->quarto->getAvailableBadroomsForEdition($reserva->tp_modo_reserva, $id);
		if($id){
			$this->load->view('index', array(
						'page'=>'reserva'
						,'title'=> 'Reservas'
						,'part' => 'editing'
						,'reserva'=> $reserva
						,'quartos'=> $quartos));
		}else{
			$this->searching();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_reserva');
		$reserva = $this->reserva->getFullCurrentReservation( $id);
		$quartos = $this->quarto->getAvailableBadroomsForEdition($reserva->tp_modo_reserva, $id);
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

		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('id_quarto','entrada'),$this->input->post());
			
			$dados['entrada'] = dateTimeToUs($dados['entrada']);
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
			
			$dados = elements(array('id_quarto','entrada','id_situacao'),$this->input->post());
			$dados['entrada'] = dateTimeToUs($dados['entrada']);
			
			$this->db->where('id_reserva', $this->input->post('id_reserva'));
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
		
		$this->form_validation->set_rules('entrada', 'Entrada', 'required');
		$this->form_validation->set_rules('id_quarto', 'Quarto', 'required');
		
		return $this->form_validation->run();
	
	}
	
	public function quartos(){
		$tipo = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		if($tipo){
			$quartos = $this->quarto->getAvailableBadroomsForEdition($tipo, $id);
			echo json_encode($quartos);
		}
	}
	
}
