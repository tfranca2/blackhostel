<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quarto extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
	 
	public function index(){
		
		$this->load->view('index', array(
					'page'=>'quarto'
					,'title'=> 'Quarto'
					,'part' => 'searching'
					,'perfils' => $this->db->get('perfil')->result()
					,'tabledata'=>$this->getQuartoFromDB()
				));
	}
	
	public function searching(){
		$this->db->like('quarto.descricao', $this->input->get('descricao'));
		$this->db->like('quarto.id_perfil', $this->input->get('id_per'));
		$quartos = $this->getQuartoFromDB();
		
		$this->load->view('index',array(
					'page'=>'quarto'
					,'title'=> 'Quarto'
					,'part' => 'searching'
					,'perfils' => $this->getPerfilsFromDB()
					,'tabledata'=> $quartos
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'quarto'
					,'title'=> 'Quarto'
					,'perfils' => $this->getPerfilsFromDB()
					,'part' => 'inserting'));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_quarto');
		if($id){
			
			$this->load->view('index', array(
						'page'=>'quarto'
						,'title'=> 'Quarto'
						,'part' => 'editing'
						,'perfils' => $this->getPerfilsFromDB()
						,'quarto'=>$this->getQuartoFromDB($id) ));
		}else{
			$this->searching();
		}
	}
	
	public function getQuartoFromDB($id = 0){
		
		$this->db->select('quarto.id_quarto id_quarto, quarto.numero, quarto.descricao ds_quarto, perfil.descricao ds_perfil, perfil.preco_base preco_perfil, perfil.id_perfil idperfil');    
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
						'page'=>'quarto'
						,'title'=> 'Quarto'
						,'part' => 'deleting'
						,'perfils' => $this->db->get('perfil')->result()
						,'quarto'=>$this->getQuartoFromDB($id) ));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('descricao','numero','id_perfil'),$this->input->post());
			$this->db->insert('quarto', $dados); 
			
			$this->load->view('index',array(
					'page'=>'quarto'
					,'title'=> 'Quarto'
					,'part' => 'inserting'
			));
			
			$this->session->set_flashdata('msg', 'Quarto cadastrado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->inserting();
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			
			$dados = elements(array('descricao','numero','id_perfil'),$this->input->post());
			$this->db->where('id_quarto', $this->input->post('id_quarto'));
			$this->db->update('quarto', $dados); 
			
			$this->session->set_flashdata('msg', 'Quarto atualizado com sucesso.');
			$this->index();
			//redirect(current_url());
			
		}else{	
			$this->editing();
		}
		
	}
	
	public function delete(){
		if ($this->runFormValidations() == TRUE){
			
			
			$this->db->where('id_quarto', $this->input->post('id_quarto'));
			$this->db->delete('quarto'); 
			
			$this->session->set_flashdata('msg', 'Quarto deletado com sucesso.');
			redirect(current_url());
			
		}else{
			$this->deleting();
		}
	}
	
	private function runFormValidations(){
		
		$this->form_validation->set_rules('descricao', 'Descrição', 'trim|required|min_length[5]|max_length[60]|ucwords');
		
		return $this->form_validation->run();
	
	}
	
	
}
