<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Situacao extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Login_model','login');
		$this->login->authorize();
    }
	 
	public function index(){
		$this->load->view('index', array(
					'page'=>'situacao'
					,'title'=> 'Situações'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('situacao')->result()
				));
	}
	
	public function searching(){
		$this->db->like('situacao', $this->input->get('situacao'));
		
		$this->load->view('index',array(
					'page'=>'situacao'
					,'title'=> 'Situações'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('situacao')->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'situacao'
					,'title'=> 'Situações'
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_situacao');
		if($id){
			$this->load->view('index', array(
						'page'=>'situacao'
						,'title'=> 'Situações'
						,'part' => 'editing'
						,'situacao'=> $this->db->get_where('situacao', array('id_situacao' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_situacao');
		if($id){
			$this->load->view('index', array(
						'page'=>'situacao'
						,'title'=> 'Situações'
						,'part' => 'deleting'
						,'situacao'=> $this->db->get_where('situacao', array('id_situacao' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('situacao'),$this->input->post());
			$this->db->insert('situacao', $dados); 
			
			$this->load->view('index',array(
					'page'=>'situacao'
					,'title'=> 'situacoes'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Situação cadastrada com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('situacao'),$this->input->post());
			$this->db->where('id_situacao', $this->input->post('id_situacao'));
			$this->db->update('situacao', $dados); 
			
			$this->session->set_flashdata('msg', 'Situação atualizada com sucesso.');
			redirect(current_url());
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_situacao', $this->input->post('id_situacao'));
			$this->db->delete('situacao'); 
			
			$this->session->set_flashdata('msg', 'Situação deletada com sucesso.');
			redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
	private function runFormValidations(){
	
		
		$this->form_validation->set_message('situacao',"%s é um campo obrigatório.");
		
		
		$this->form_validation->set_rules('situacao', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		
		return $this->form_validation->run();
	
	}
	
	
}
