<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array'));
		$this->load->library('form_validation');
		$this->load->database();
    }
	 
	public function index(){
		$viewData = array('part' => 'search','tabledata'=>$this->db->get('item')->result());
		$this->load->view('item', $viewData);
	}
	
	public function search(){
		$this->db->like('descricao', $this->input->get('descricao'));
		$viewData = array('part' => 'search','tabledata'=>$this->db->get('item')->result());
		$this->load->view('item', $viewData);
		$this->db->like('title', 'match'); 
	}
	
	public function insert(){
		$viewData = array('part' => 'insert');
		$this->load->view('item', $viewData);
	}
	
	
	public function save(){
		$this->form_validation->set_message('monetary',"%s não corresponde a um padrão de moeda.");
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		//$this->form_validation->set_rules('preco', 'Preço', 'required|monetary');
		$this->form_validation->set_rules('preco', 'Preço', 'required');
		
		if ($this->form_validation->run() == FALSE){
			$viewData = array('part' => 'insert');
			$this->load->view('item', $viewData);
		}else{
			
			$dados = elements(array('descricao','preco'),$this->input->post());
			$this->db->insert('item', $dados); 
			
			$viewData = array(
			'msg' => 'Item cadastrado com sucesso'
			,'part' => 'insert'
			);
			
			$this->load->view('item',$viewData);
		}
		
	}
	
	public function monetary($str){
		if(preg_match('/^[\d\.\,]+$/', $str)){
			return TRUE;
		}
		return FALSE;
	}
	
	
	
	
}
