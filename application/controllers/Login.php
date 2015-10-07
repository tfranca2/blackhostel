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
		$this->login->login();
	}
	
	public function logout(){
		$this->login->logout();
	}
}
