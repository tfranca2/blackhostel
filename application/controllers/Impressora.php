<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Impressora extends CI_Controller {

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
					'page'=>'impressora'
					,'title'=> 'Impressoras'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('impressora')->result()
				));
	}
	
	public function searching(){
		$this->db->like('impressora', $this->input->get('descricao'));
		
		$this->load->view('index',array(
					'page'=>'impressora'
					,'title'=> 'Impressoras'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('impressora')->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'impressora'
					,'title'=> 'Impressora'
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_impressora');
		if($id){
			$this->load->view('index', array(
						'page'=>'impressora'
						,'title'=> 'Impressora'
						,'part' => 'editing'
						,'impressora'=> $this->db->get_where('impressora', array('id_impressora' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_impressora');
		if($id){
			$this->load->view('index', array(
						'page'=>'impressora'
						,'title'=> 'Impressoras'
						,'part' => 'deleting'
						,'impressora'=> $this->db->get_where('impressora', array('id_impressora' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements( array( 'descricao', 'ip', 'perfil' ), $this->input->post() );
			
			$this->db->insert('impressora', $dados); 
			
			$this->load->view('index',array(
					'page'=>'impressora'
					,'title'=> 'impressoras'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Impressora cadastrada com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements( array( 'descricao', 'ip', 'perfil' ), $this->input->post() );

			$this->db->where('id_impressora', $this->input->post('id_impressora'));
			$this->db->update('impressora', $dados); 
			
			$this->session->set_flashdata('msg', 'Impressora atualizada com sucesso.');
			redirect(current_url());
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_impressora', $this->input->post('id_impressora'));
			$this->db->delete('impressora'); 
			
			$this->session->set_flashdata('msg', 'Impressora deletada com sucesso.');
			redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
	public function load(){
		$impressoraName = $this->input->get('impressoraName');
		$this->db->like('impressora', $impressoraName );
		echo json_encode($this->db->get('impressora')->result());
	}
	
	private function runFormValidations(){
	
		$this->form_validation->set_message('descricao',"%s é um campo obrigatório.");
		$this->form_validation->set_message('ip',"%s é um campo obrigatório.");
		
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		$this->form_validation->set_rules('ip', 'IP', 'trim|required');
		
		return $this->form_validation->run();
	
	}
}
