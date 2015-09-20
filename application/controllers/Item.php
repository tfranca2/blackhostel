<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
	 
	public function index(){
		
		$this->load->view('index', array(
					'page'=>'item'
					,'title'=> 'Itens'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('item')->result()
				));
	}
	
	public function searching(){
		$this->db->like('descricao', $this->input->get('descricao'));
		
		$this->load->view('index',array(
					'page'=>'item'
					,'title'=> 'Itens'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('item')->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'item'
					,'title'=> 'Itens'
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_item');
		if($id){
			$this->load->view('index', array(
						'page'=>'item'
						,'title'=> 'Itens'
						,'part' => 'editing'
						,'item'=> $this->db->get_where('item', array('id_item' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('descricao','preco'),$this->input->post());
			$this->db->insert('item', $dados); 
			
			$this->load->view('index',array(
					'page'=>'item'
					,'title'=> 'Itens'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Item cadastrado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('descricao','preco'),$this->input->post());
			
			$this->db->where('id_item', $this->input->post('id_item'));
			$this->db->update('item', $dados); 
			
			$this->session->set_flashdata('msg', 'Item atualizado com sucesso.');
			redirect(current_url());
			
			
		}else{
			$this->editing();
		}
	}
	
	private function runFormValidations(){
	
		$this->form_validation->set_message('monetary',"%s não corresponde a um padrão de moeda.");
		
		$this->form_validation->set_message('descricao',"%s é um campo obrigatório.");
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		$this->form_validation->set_rules('preco', 'Preço', 'required');
		
		return $this->form_validation->run();
	
	}
	
	public function monetary($str){
		return (preg_match('/^[\d\.\,]+$/', $str))?TRUE:FALSE;
	}
	
}
