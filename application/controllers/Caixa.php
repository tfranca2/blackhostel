<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa extends CI_Controller {

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
					'page'=>'caixa'
					,'title'=> 'Movimento de Caixa'
					,'part' => 'show'
					,'tabledata'=>$this->db->query("SELECT * FROM caixa WHERE `id_caixa` >= ( SELECT `id_caixa` FROM caixa WHERE operacao = 1 ORDER BY id_caixa DESC LIMIT 1)")->result()
				));
	}
	
	public function show(){
		$this->load->view('index',array(
					'page'=>'caixa'
					,'title'=> 'Movimento de Caixa'
					,'part' => 'show'
					,'tabledata'=>$this->db->get('caixa')->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'caixa'
					,'title'=> 'Movimento de Caixa'
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_caixa');
		if($id){
			$this->load->view('index', array(
						'page'=>'caixa'
						,'title'=> 'Movimento de Caixa'
						,'part' => 'editing'
						,'caixa'=> $this->db->get_where('caixa', array('id_caixa' => $id))->row() ));
		}else{
			$this->show();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_caixa');
		if($id){
			$this->load->view('index', array(
						'page'=>'caixa'
						,'title'=> 'Movimento de Caixa'
						,'part' => 'deleting'
						,'caixa'=> $this->db->get_where('caixa', array('id_caixa' => $id))->row() ));
		}else{
			$this->show();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$user = $this->session->get_userdata();
			$id_usuario = $user['user_session']['id_usuario'];
			$data = date("Y-m-d H:i:s");
			
			$dados = elements(array('operacao','valor','observacao'),$this->input->post());
			$dados['id_usuario'] = $id_usuario;
			$dados['data'] = $data;
			$dados['valor'] = monetaryInput($dados['valor']);
			// VALIDA��ES AQUI
			
			
			if ( $dados['operacao'] == 1 ) { // abertura 
				$result = $this->db->query("SELECT operacao FROM caixa ORDER BY id_caixa DESC LIMIT 1")->row();
				if ( $result->operacao == 4 ) { // abertura somente ap�s um fechamento
					// valor == ao fechamento anterior
					$result = $this->db->query("SELECT valor FROM caixa WHERE operacao = 4 ORDER BY id_caixa DESC LIMIT 1")->row();
					
					$dados['valor'] = $result->valor;					
				} else {
					$this->session->set_flashdata('msg', 'Fa�a a abertura apenas ap�s um fechamento.');
					
					redirect(current_url());
				}
			} else if( $dados['operacao'] == 4 ) { // fechamento
				$result = $this->db->query("SELECT id_usuario FROM caixa WHERE operacao = 1 ORDER BY id_caixa DESC LIMIT 1")->row();
				if ( $result->id_usuario == $dados['id_usuario'] ) {
					// abertura + calculo dos creditos e debitos do dia
					$result = $this->db->query("SELECT SUM( IF( operacao IN ( 1, 3, 5 ), valor , IF( operacao IN ( 2, 6 ), (valor*-1) , 0 )  ) ) AS valor_fechamento FROM caixa WHERE `id_caixa` >= (SELECT `id_caixa` FROM caixa WHERE operacao = 1 ORDER BY id_caixa DESC LIMIT 1)")->row();

					$dados['valor'] = $result->valor_fechamento;
				} else {
					$this->session->set_flashdata('msg', 'O mesmo usu�rio deve fazer a abertura e o fechamento.');
					
					redirect(current_url());
				}
			} else { // outras opera��es
				
			}
			
			$this->db->insert('caixa', $dados); 
			
			$this->load->view('index',array(
					'page'=>'caixa'
					,'title'=> 'Movimento de Caixa'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Movimenta��o cadastrado com sucesso.');
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$user = $this->session->get_userdata();
			$id_usuario = $user['user_session']['id_usuario'];
			$data = date("Y-m-d H:i:s");
			
			$dados = elements(array('operacao','valor','observacao'),$this->input->post());
			$dados['id_usuario'] = $id_usuario;
			$dados['data'] = $data;
			
			$this->db->where('id_caixa', $this->input->post('id_caixa'));
			$this->db->update('caixa', $dados); 
			
			$this->session->set_flashdata('msg', 'Caixa atualizado com sucesso.');
			$this->show();
			// redirect(s());
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_caixa', $this->input->post('id_caixa'));
			$this->db->delete('caixa'); 
			
			$this->session->set_flashdata('msg', 'Caixa deletado com sucesso.');
			$this->show();
			//redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
	private function runFormValidations(){
	
		$this->form_validation->set_message('operacao',"%s é um campo obrigatório.");
		$this->form_validation->set_rules('operacao', 'Operacao', 'required');
		
		return $this->form_validation->run();
	
	}
}
