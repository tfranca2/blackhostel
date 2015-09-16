<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array'));
		$this->load->library('form_validation');
		$this->load->database();
    }
	 
	public function index(){
		
		$this->load->view('item', array(
					'part' => 'search'
					,'tabledata'=>$this->db->get('item')->result()
				));
	}
	
	public function search(){
		$this->db->like('descricao', $this->input->get('descricao'));
		
		$this->load->view('item',array(
					'part' => 'search'
					,'tabledata'=>$this->db->get('item')->result()
				));
	}
	
	public function insert(){
		$this->load->view('item', array('part' => 'insert'));
	}
	
	
	public function save(){
		$this->form_validation->set_message('monetary',"%s não corresponde a um padrão de moeda.");
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		$this->form_validation->set_rules('preco', 'Preço', 'required');
		
		if ($this->form_validation->run() == TRUE){
			
			$dados = elements(array('descricao','preco'),$this->input->post());
			$this->db->insert('item', $dados); 
			
			$this->load->view('item',array(
					'msg' => 'Item cadastrado com sucesso'
					,'part' => 'insert'
				));
			
		}else{
			$this->load->view('item', array('part' => 'insert'));
		}
	}
	
	public function monetary($str){
		return (preg_match('/^[\d\.\,]+$/', $str))?TRUE:FALSE;
	}
	
}
