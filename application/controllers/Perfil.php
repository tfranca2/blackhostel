<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
	 
	public function index(){
		$this->load->view('index', array(
					'page'=>'perfil'
					,'title'=> 'Perfil'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('perfil')->result()
				));
	}
	
	public function searching(){
		$this->db->like('descricao', $this->input->get('descricao'));
		
		$this->load->view('index',array(
					'page'=>'perfil'
					,'title'=> 'Perfis'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('perfil')->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'perfil'
					,'title'=> 'Perfis'
					,'part' => 'inserting'
					,'itens'=> $this->db->get('item')->result()));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_perfil');
		if($id){
			$this->load->view('index', array(
						'page'=>'perfil'
						,'title'=> 'Perfis'
						,'part' => 'editing'
						,'perfil'=> $this->db->get_where('perfil', array('id_perfil' => $id))->row() 
						,'itens'=> $this->db->get('item')->result()
						,'perfilItens'=> $this->itensPerfil($id) ));
						
					
		}else{
			$this->searching();
		}
	}
	
	public function itensPerfil($id){
		$this->db->select('id_item');
		$ids = $this->db->get_where('perfil_item', array('id_perfil' => $id))->result_array();
		$out = array();
		foreach($ids as $id){
			array_push($out, $id['id_item']);
		}
		return $out;
	}
	
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_perfil');
		if($id){
			$this->load->view('index', array(
						'page'=>'perfil'
						,'title'=> 'Perfis'
						,'part' => 'deleting'
						,'perfil'=> $this->db->get_where('perfil', array('id_perfil' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('descricao','preco_base'),$this->input->post());
			$dados['preco_base'] = monetaryInput($dados['preco_base']);
			$this->db->insert('perfil', $dados); 
			$last_id = $this->db->insert_id();
			
			$itens = $this->input->post('itens[]');
			
			foreach($itens as $item){
				$data = array(
				   'id_perfil' => $last_id, 
				   'id_item' => $item
				 );	
				$this->db->insert('perfil_item', $data); 	
			}
			
			$this->load->view('index',array(
					'page'=>'perfil'
					,'title'=> 'Perfis'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Perfil cadastrado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('descricao','preco_base'),$this->input->post());
			$dados['preco_base'] = monetaryInput($dados['preco_base']);
			$this->db->where('id_perfil', $this->input->post('id_perfil'));
			$this->db->update('perfil', $dados); 
			
			$itens = $this->input->post('itens[]');
			$this->db->delete('perfil_item',array('id_perfil' => $this->input->post('id_perfil')));
			
			foreach($itens as $item){
				$data = array(
				   'id_perfil' =>$this->input->post('id_perfil'), 
				   'id_item' => $item
				 );
				$this->db->insert('perfil_item', $data); 	
			}
			
			$this->session->set_flashdata('msg', 'Perfil atualizado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_perfil', $this->input->post('id_perfil'));
			$this->db->delete('perfil'); 
			
			$this->session->set_flashdata('msg', 'Perfil deletado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
	private function runFormValidations(){
	
		$this->form_validation->set_message('monetary',"%s não corresponde a um padrão de moeda.");
		
		$this->form_validation->set_message('descricao',"%s é um campo obrigatório.");
		
		
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		$this->form_validation->set_rules('preco_base', 'Preço', 'required');
		
		return $this->form_validation->run();
	
	}
	
	
}
