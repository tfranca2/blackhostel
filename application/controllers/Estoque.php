<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estoque extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Login_model','login');
		$this->login->authorize();
    }
	 
	public function index(){
		
		$sql = "SELECT * FROM produto";
		
		$this->load->view('index', array(
					'page'=>'estoque'
					,'title'=> 'Estoque'
					,'part' => 'searching'
					,'tabledata'=>$this->db->query($sql)->result()
				));
	}
	
	public function searching(){
		$sql = "SELECT *
				FROM produto
				WHERE produto LIKE '%".$this->input->get('produto')."%' ";
		
		$this->load->view('index',array(
					'page'=>'estoque'
					,'title'=> 'Estoque'
					,'part' => 'searching'
					,'tabledata'=>$this->db->query($sql)->result()
				));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_produto');
		if($id){
			$this->load->view('index', array(
					'page'=>'estoque'
					,'title'=> 'Estoque'
					,'part' => 'editing'
					,'produto'=>$this->db->get_where('produto', array('id_produto' => $id))->row() ));
		} else {
			$this->searching();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_produto');
			
			$dados = elements(array('id_produto', 'estoque'),$this->input->post());

			$this->db->where('id_produto', $id );
			$this->db->update('produto', $dados); 
			
			$this->session->set_flashdata('msg', 'Estoque cadastrado com sucesso.');
			
			$this->searching();
			
		}else{
			$this->searching();
		}
	}

	private function runFormValidations(){
	
		$this->form_validation->set_rules('estoque', 'Estoque', 'required');
		
		return $this->form_validation->run();
	
	}
	
	
}
