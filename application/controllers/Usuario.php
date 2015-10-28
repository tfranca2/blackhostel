<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
	 
	public function index(){
		$this->load->view('index', array(
					'page'=>'usuario'
					,'title'=> 'Usuários'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('usuario')->result()
				));
	}
	
	public function searching(){
		$this->db->like('nome', $this->input->get('nome'));
		
		$this->load->view('index',array(
					'page'=>'usuario'
					,'title'=> 'Usuários'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('usuario')->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'usuario'
					,'title'=> 'Usuários'
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_usuario');
		if($id){
			$this->load->view('index', array(
						'page'=>'usuario'
						,'title'=> 'Usuários'
						,'part' => 'editing'
						,'usuario'=> $this->db->get_where('usuario', array('id_usuario' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_usuario');
		if($id){
			$this->load->view('index', array(
						'page'=>'usuario'
						,'title'=> 'Usuários'
						,'part' => 'deleting'
						,'usuario'=> $this->db->get_where('usuario', array('id_usuario' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('nome','login','senha'),$this->input->post());
			$this->db->insert('usuario', $dados); 
			
			$this->load->view('index',array(
					'page'=>'usuario'
					,'title'=> 'usuarios'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Usuário cadastrado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('nome','login','senha'),$this->input->post());
			$this->db->where('id_usuario', $this->input->post('id_usuario'));
			$this->db->update('usuario', $dados); 
			
			$this->session->set_flashdata('msg', 'Usuário atualizado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_usuario', $this->input->post('id_usuario'));
			$this->db->delete('usuario'); 
			
			$this->session->set_flashdata('msg', 'Usuário deletado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
	private function runFormValidations(){
	
		$this->form_validation->set_message('nome',"%s é um campo obrigatório.");
		$this->form_validation->set_message('login',"%s é um campo obrigatório.");
		$this->form_validation->set_message('senha',"%s é um campo obrigatório.");
		
		$this->form_validation->set_rules('nome', 'Nome', 'required|min_length[3]|max_length[100]');
		$this->form_validation->set_rules('login', 'Login', 'required');
		$this->form_validation->set_rules('senha', 'Senha', 'required');
		
		return $this->form_validation->run();
	
	}
}
