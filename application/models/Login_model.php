<?php

class Login_model extends CI_Model {

    function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session'));
    }
	
	public function authorize(){
		if(!$this->session->userdata('user_session')){
			redirect('/login', 'refresh');
		}
	}
	
	public function login(){
		$this->form_validation->set_rules('username', 'Usuário', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required');
		
		if($this->form_validation->run()){
			
			$usuario = $this->db->get_where('usuario', array('login' => $this->input->post("username")))->row();
			
			if(empty($usuario))
				return false;
			
			if($usuario->senha == md5($this->input->post("password"))){
				
				$newdata = array(
					   'id_usuario'  => $usuario->id_usuario,
					   'nome'  => $usuario->nome,
					   'email'     => $usuario->login,
					   'senha'     => $usuario->senha,
					   'gerente'     => $usuario->gerente,
					   'admin'     => $usuario->admin
				   );
				$this->session->set_userdata('user_session',$newdata);
				return true;
			
			}else{
				return false;
			}
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('/login', 'refresh');
	}
}

?>
