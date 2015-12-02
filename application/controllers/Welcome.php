<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
    }
	
	public function index()
	{
		$this->load->view('welcome_message', array(
					'page'=>'welcome'
					,'title'=> 'Welcome'
				));
	}
}
