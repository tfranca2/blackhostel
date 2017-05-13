<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produto extends CI_Controller {

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
					'page'=>'produto'
					,'title'=> 'Produtos'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('produto')->result()
				));
	}
	
	public function searching(){
		$this->db->like('produto', $this->input->get('produto'));
		
		$this->load->view('index',array(
					'page'=>'produto'
					,'title'=> 'Produtos'
					,'part' => 'searching'
					,'tabledata'=>$this->db->get('produto')->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'produto'
					,'title'=> 'Produtos'
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_produto');
		if($id){
			$this->load->view('index', array(
						'page'=>'produto'
						,'title'=> 'Produtos'
						,'part' => 'editing'
						,'produto'=> $this->db->get_where('produto', array('id_produto' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_produto');
		if($id){
			$this->load->view('index', array(
						'page'=>'produto'
						,'title'=> 'Produtos'
						,'part' => 'deleting'
						,'produto'=> $this->db->get_where('produto', array('id_produto' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('produto','preco'),$this->input->post());
			$dados['preco'] = monetaryInput($dados['preco']);
			$this->db->insert('produto', $dados); 
			
			$this->load->view('index',array(
					'page'=>'produto'
					,'title'=> 'Produtos'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Produto cadastrado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('produto','preco'),$this->input->post());
			$dados['preco'] = monetaryInput($dados['preco']);
			$this->db->where('id_produto', $this->input->post('id_produto'));
			$this->db->update('produto', $dados); 
			
			$this->session->set_flashdata('msg', 'Produto atualizado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_produto', $this->input->post('id_produto'));
			$this->db->delete('produto'); 
			
			$this->session->set_flashdata('msg', 'Produto deletado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
    public function pesquisaProduto() {
        $codigo = $this->input->post('codigo');
        echo json_encode( $this->db->get_where('produto', array('id_produto' => $codigo))->row() );
    }
	
	private function runFormValidations(){
	
		$this->form_validation->set_message('monetary',"%s não corresponde a um padrão de moeda.");
		
		$this->form_validation->set_message('produto',"%s é um campo obrigatório.");
		
		
		$this->form_validation->set_rules('produto', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		$this->form_validation->set_rules('preco', 'Preço', 'required');
		
		return $this->form_validation->run();
	
	}

}
