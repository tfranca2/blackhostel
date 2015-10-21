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
		if($id){
			$this->load->view('index', array(
						'page'=>'reserva'
						,'title'=> 'Reservas'
						,'part' => 'editing'
						,'quartos'=> $this->quarto->getQuartosDisponiveisTipoReserva()->result()
						,'reserva'=> $this->db->get_where('reserva', array('id_reserva' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_reserva');
		if($id){
			$this->load->view('index', array(
						'page'=>'reserva'
						,'title'=> 'Reservas'
						,'part' => 'deleting'
						,'quartos'=> $this->quarto->getQuartosDisponiveis()->result()
						,'reserva'=> $this->db->get_where('reserva', array('id_reserva' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){

		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('id_quarto','entrada'),$this->input->post());
			
			$dados['entrada'] = dateTimeToUs($dados['entrada']);
			$dados['situacao'] =self::RESERVADO;
			$this->db->insert('reserva', $dados); 
			
			$this->load->view('index',array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Reserva registrada com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('id_quarto','entrada','situacao'),$this->input->post());
			$dados['entrada'] = dateTimeToUs($dados['entrada']);
			
			$this->db->where('id_reserva', $this->input->post('id_reserva'));
			$this->db->update('reserva', $dados); 
			
			$this->session->set_flashdata('msg', 'Reserva atualizado com sucesso.');
			$this->index();
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){

			$this->db->where('id_reserva', $this->input->post('id_reserva'));
			$this->db->delete('reserva'); 
			
			$this->session->set_flashdata('msg', 'reserva deletado com sucesso.');

			$this->deleting();
		
	}
	
	private function runFormValidations(){
		
		$this->form_validation->set_rules('entrada', 'Entrada', 'required');
		$this->form_validation->set_rules('id_quarto', 'Quarto', 'required');
		
		return $this->form_validation->run();
	
	}
	
	public function quartos(){
	$tipo = $this->uri->segment(3);
		if($tipo){
			$quartos = $this->quarto->getQuartosDisponiveisTipoReserva($tipo)->result();
			echo json_encode($quartos);
		}
	}
	
}
