<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
	 
	public function index(){
		$this->load->view('index', array(
					'page'=>'cliente'
					,'title'=> 'Clientes'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('cliente')->result()
				));
	}
	
	public function searching(){
		$this->db->like('cliente', $this->input->get('cliente'));
		
		$this->load->view('index',array(
					'page'=>'cliente'
					,'title'=> 'Clientes'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('cliente')->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'cliente'
					,'title'=> 'Clientes'
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_cliente');
		if($id){
			$this->load->view('index', array(
						'page'=>'cliente'
						,'title'=> 'Clientes'
						,'part' => 'editing'
						,'cliente'=> $this->db->get_where('cliente', array('id_cliente' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_cliente');
		if($id){
			$this->load->view('index', array(
						'page'=>'cliente'
						,'title'=> 'Clientes'
						,'part' => 'deleting'
						,'cliente'=> $this->db->get_where('cliente', array('id_cliente' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('cliente','cpf','rg'),$this->input->post());
			$this->db->insert('cliente', $dados); 
			
			$this->load->view('index',array(
					'page'=>'cliente'
					,'title'=> 'clientes'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Cliente cadastrado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('cliente','cpf','rg'),$this->input->post());
			$this->db->where('id_cliente', $this->input->post('id_cliente'));
			$this->db->update('cliente', $dados); 
			
			$this->session->set_flashdata('msg', 'Cliente atualizado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_cliente', $this->input->post('id_cliente'));
			$this->db->delete('cliente'); 
			
			$this->session->set_flashdata('msg', 'Cliente deletado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
	private function runFormValidations(){
	
		$this->form_validation->set_message('cliente',"%s é um campo obrigatório.");
		$this->form_validation->set_message('cpf',"%s é um campo obrigatório.");
		$this->form_validation->set_message('rg',"%s é um campo obrigatório.");
		
		$this->form_validation->set_rules('cliente', 'Nome', 'trim|required|min_length[5]|max_length[60]|ucwords');
		$this->form_validation->set_rules('cpf', 'cpf', 'required');
		$this->form_validation->set_rules('rg', 'rg', 'required');
		
		return $this->form_validation->run();
	
	}
	
}
