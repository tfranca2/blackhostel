<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caixa extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app','printer'));
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

			if ( $dados['operacao'] == 1 ) { // abertura 
				$result = $this->db->query("SELECT operacao FROM caixa ORDER BY id_caixa DESC LIMIT 1")->row();
				if ( $result->operacao == 4 ) { // abertura somente após um fechamento
					// valor abertura == ao fechamento anterior
					$result = $this->db->query("SELECT valor FROM caixa WHERE operacao = 4 ORDER BY id_caixa DESC LIMIT 1")->row();
					
					$dados['valor'] = $result->valor;					
				} else {
					$this->session->set_flashdata('msg', 'Fa&ccedil;a a abertura apenas ap&oacute;s um fechamento.');
					
					redirect(current_url());
				}
			} else if( $dados['operacao'] == 4 ) { // fechamento
				$result = $this->db->query("SELECT id_usuario FROM caixa WHERE operacao = 1 ORDER BY id_caixa DESC LIMIT 1")->row();
				if ( $result->id_usuario == $dados['id_usuario'] ) { // apenas o usuario que abriu pode fechar
					$result = $this->db->query("SELECT operacao FROM caixa WHERE id_caixa = (SELECT MAX(id_caixa) FROM caixa WHERE operacao IN( 1, 4 ))")->row();
					if ( $result->operacao == 1 ) {
						// valor fechamento == abertura + calculo de creditos e debitos do dia
						$result = $this->db->query("SELECT SUM( IF( operacao IN ( 1, 3, 5 ), valor , IF( operacao IN ( 2, 6 ), (valor*-1) , 0 )  ) ) AS valor_fechamento FROM caixa WHERE `id_caixa` >= (SELECT `id_caixa` FROM caixa WHERE operacao = 1 ORDER BY id_caixa DESC LIMIT 1)")->row();

						$dados['valor'] = $result->valor_fechamento;
					} else {
						$this->session->set_flashdata('msg', 'Voc&ecirc; n&atilde;o pode fazer dois fechamentos seguidos.');
						
						redirect(current_url());
					}
				} else {
					$this->session->set_flashdata('msg', 'O mesmo usu&aacute;rio deve fazer a abertura e o fechamento.');
					
					redirect(current_url());
				}
			} else { // outras operações
				$result = $this->db->query("SELECT operacao FROM caixa WHERE id_caixa = (SELECT MAX(id_caixa) FROM caixa WHERE operacao IN( 1, 4 ))")->row();
				if ( $result->operacao == 4 ) { 
					$this->session->set_flashdata('msg', '&Eacute; necess&aacute;rio fazer a abertura de caixa antes de adicionar algum lan&ccedil;amento.');
					
					redirect(current_url());
				}
			}
			
			if($dados['operacao'] == 4){
				$caixa = $this->db->query("SELECT * FROM caixa WHERE `id_caixa` >= ( SELECT `id_caixa` FROM caixa WHERE operacao = 1 ORDER BY id_caixa DESC LIMIT 1)")->result();
				$cash->operacao =  $dados['operacao'];
				$cash->valor =  $dados['valor'];
				$cash->observacao =  $dados['observacao'];
				array_push($caixa, $cash);
			
				printCaixa($caixa, $user['user_session']['nome']);
			}
			
			$this->db->insert('caixa', $dados); 
			
			$this->load->view('index',array(
					'page'=>'caixa'
					,'title'=> 'Movimento de Caixa'
					,'part' => 'show'
					,'tabledata'=>$this->db->query("SELECT * FROM caixa WHERE `id_caixa` >= ( SELECT `id_caixa` FROM caixa WHERE operacao = 1 ORDER BY id_caixa DESC LIMIT 1)")->result()
			));
			
			$this->session->set_flashdata('msg', 'Movimenta&ccedil;&atilde;o cadastrado com sucesso.');
			
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
