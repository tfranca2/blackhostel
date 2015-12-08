<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Login_model','login');
		$this->login->authorize();
    }
	 
	public function index(){
		
		// pegando mac no windows
		//$clientMac = "80-EE-73-56-E9-2F";
		//$macs = utf8_decode( shell_exec('getmac'));
		
		//pegando mec no linux
		//exec('netstat -ie', $infos);
		//$macs = $infos[1];
		
		
		// definir uma constante com o mac da máquina e encriptar e usar eval para executar
		eval('define("LOCK_MAC", "80-EE-73-56-E9-2F");');
		//eval(base64_decode("ZGVmaW5lKCJMT0NLX01BQyIsICJiODphZTplZDo4NDozZTplZCIpOw=="));
		
// 		if (!strpos($macs,LOCK_MAC) !== false) {
// 			die;
// 		}
		
		eval(base64_decode("aWYgKCFzdHJwb3MoJG1hY3MsTE9DS19NQUMpICE9PSBmYWxzZSkgew0KCQkJZGllOw0KCQl9"));
		
		
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
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_item');
		if($id){
			$this->load->view('index', array(
						'page'=>'item'
						,'title'=> 'Itens'
						,'part' => 'deleting'
						,'item'=> $this->db->get_where('item', array('id_item' => $id))->row() ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('descricao','preco'),$this->input->post());
			$dados['preco'] = monetaryInput($dados['preco']);
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
			$dados['preco'] = monetaryInput($dados['preco']);
			$this->db->where('id_item', $this->input->post('id_item'));
			$this->db->update('item', $dados); 
			
			$this->session->set_flashdata('msg', 'Item atualizado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->editing();
		}
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_item', $this->input->post('id_item'));
			$this->db->delete('item'); 
			
			$this->session->set_flashdata('msg', 'Item deletado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
	private function runFormValidations(){
	
		$this->form_validation->set_message('monetary',"%s não corresponde a um padrão de moeda.");
		
		$this->form_validation->set_message('descricao',"%s é um campo obrigatório.");
		
		
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		$this->form_validation->set_rules('preco', 'Preço', 'required');
		
		return $this->form_validation->run();
	
	}
	
	
}
