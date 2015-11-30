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
		
		$sql = "SELECT 
					p.produto AS produto, 
					SUM(e.quantidade) AS quantidade 
				FROM estoque e 
				INNER JOIN produto p 
					ON p.id_produto = e.id_produto
				GROUP BY p.id_produto
				";
		
		$this->load->view('index', array(
					'page'=>'estoque'
					,'title'=> 'Movimento de estoque'
					,'part' => 'searching'
					,'tabledata'=>$this->db->query($sql)->result()
				));
	}
	
	public function searching(){
		$sql = "SELECT 
					p.produto AS produto, 
					SUM(e.quantidade) AS quantidade 
				FROM estoque e 
				INNER JOIN produto p 
					ON p.id_produto = e.id_produto
				WHERE p.produto LIKE '%".$this->input->get('produto')."%'
				GROUP BY p.id_produto ";
		
		$this->load->view('index',array(
					'page'=>'estoque'
					,'title'=> 'Movimento de estoque'
					,'part' => 'searching'
					,'tabledata'=>$this->db->query($sql)->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'estoque'
					,'title'=> 'Movimento de estoque'
					,'part' => 'inserting'
					,'produtos'=>$this->db->get('produto')->result()
					));
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('id_produto','quantidade'),$this->input->post());
			$user = $this->session->get_userdata();
			$dados['id_usuario'] = $user['user_session']['id_usuario'];
			$dados['data'] = date('Y-m-d H:i:s');
	
			$this->db->insert('estoque', $dados); 
			
			$this->load->view('index',array(
					'page'=>'estoque'
					,'title'=> 'Movimento de estoque'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Movimento de estoque cadastrado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}

	private function runFormValidations(){
	
		$this->form_validation->set_rules('id_produto', 'Produto', 'required');
		$this->form_validation->set_rules('quantidade', 'Quantidade', 'required');
		
		return $this->form_validation->run();
	
	}
	
	
}
