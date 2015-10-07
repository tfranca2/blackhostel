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
		$this->form_validation->set_rules('email', 'E-mail', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required');
		
		if($this->form_validation->run()){
			$newdata = array(
                   'username'  => 'johndoe',
                   'email'     => 'johndoe@some-site.com',
                   'logged_in' => TRUE
               );
			$this->session->set_userdata('user_session',$newdata);
			redirect('/', 'refresh');
		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect('/login', 'refresh');
	}
}

?>
