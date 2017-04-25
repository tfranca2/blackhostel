<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mesa extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Login_model','login');
		$this->load->model('Perfil_model','perfil');
		$this->login->authorize();
    }
	 
	public function index(){
		
		$this->load->view('index', array(
					'page'=>'mesa'
					,'title'=> 'Mesas'
					,'part' => 'searching'
					,'perfils' => $this->db->get('perfil')->result()
					,'tabledata'=>$this->getMesaFromDB()
				));
	}
	
	public function searching(){
		$this->db->like('quarto.id_perfil', $this->input->get('id_per'));
		$quartos = $this->getMesaFromDB();
		
		$this->load->view('index',array(
					'page'=>'mesa'
					,'title'=> 'Mesas'
					,'part' => 'searching'
					,'perfils' => $this->getPerfilsFromDB()
					,'tabledata'=> $quartos
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'mesa'
					,'title'=> 'Mesa'
					,'perfils' => $this->getPerfilsFromDB()
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_mesa');
		if($id){
			$this->load->view('index', array(
						'page'=>'mesa'
						,'title'=> 'Mesa'
						,'part' => 'editing'
						,'perfils' => $this->getPerfilsFromDB()
						,'quarto'=>$this->getMesaFromDB($id) ));
		}else{
			$this->searching();
		}
	}
	
	public function detail(){
		$id = $this->uri->segment(3);
		$quarto = $this->getMesaFromDB($id);
		$perfil = $this->perfil->findPerfilById($quarto->idperfil)->row();
		$perfil->total = monetaryOutput($perfil->preco_base + $perfil->preco_itens);
		echo json_encode( array("id"=>$id,"quarto"=> $quarto,"perfil"=>$perfil));
	}
	
	public function getMesaFromDB($id = 0){
		
		$this->db->select('quarto.id_quarto id_quarto, quarto.numero, perfil.descricao ds_perfil, perfil.preco_base preco_perfil, perfil.id_perfil idperfil');
		$this->db->from('quarto');
		$this->db->join('perfil', 'perfil.id_perfil = quarto.id_perfil');
		if($id){
			$this->db->where('id_quarto' , $id);
			return $this->db->get()->row();
		}else{
			return $this->db->get()->result();
		}
		
	}
	
	public function getPerfilsFromDB(){
		return $this->db->get('perfil')->result();
	}
	
	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_quarto');
		if($id){
			
			$this->load->view('index', array(
						'page'=>'mesa'
						,'title'=> 'Mesa'
						,'part' => 'deleting'
						,'perfils' => $this->db->get('perfil')->result()
						,'quarto'=>$this->getMesaFromDB($id) ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('numero','id_perfil'),$this->input->post());
			$this->db->insert('quarto', $dados); 
			
			$this->load->view('index',array(
					'page'=>'mesa'
					,'title'=> 'Mesa'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Mesa cadastrada com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('numero','id_perfil'),$this->input->post());
			$this->db->where('id_quarto', $this->input->post('id_quarto'));
			$this->db->update('quarto', $dados); 
			
			$this->session->set_flashdata('msg', 'Mesa atualizada com sucesso.');
			$this->index();
			//redirect(current_url());
			
		}else{	
			$this->editing();
		}
		
	}
	
	public function delete(){
			
			$this->db->where('id_quarto', $this->input->post('id_quarto'));
			$this->db->delete('quarto'); 
			
			$this->session->set_flashdata('msg', 'Mesa deletada com sucesso.');
			$this->index();
			
	}
	
	private function runFormValidations(){
		
		$this->form_validation->set_rules('numero', 'Número', 'required');
		return $this->form_validation->run();
	
	}
	
	
}
