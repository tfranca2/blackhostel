<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Login_model','login');
    }
	 
	public function index(){
		$this->load->view('login');
	}
	
	public function login(){
		if($this->login->login()){
			redirect('/', 'refresh');
		}else{
			$this->session->set_flashdata('message', 'Usuário ou Senha não estão corretos.');	
			redirect('/login', 'refresh');
		}
	}
	
	public function logout(){
		$this->login->logout();
	}
	
}
