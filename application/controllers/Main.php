<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app','printer'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Login_model','login');
		$this->load->model('Reserva_model','reserva');
		$this->login->authorize();
    }
	
	public function index()
	{
		$data['inicio'] = $this->input->post('inicio');
		$data['fim'] = $this->input->post('fim');
		
		$this->load->view('index', array(
					'page'=>'reports'
					,'data' => $this->reserva->getSumReservationMonths()
					,'title'=> 'Relatórios'
					,'faturamentos' => $this->reserva->getResumoFaturamentoDia($data)
					,'produtosVendidos' => $this->reserva->getVendasProdutoDia($data)
					,'filtro' => $data
		));
	}
	
	public function reports(){
		$this->index();
	}
	
	public function manual(){
		$this->load->view('index', array(
				'page'=>'manual'
				,'title'=> 'Manual do Sistema'
		));
	}
	
	public function imprimir(){
			 
printComanda('\033[1m'."+-------------------------------------+
|            BlackHostel              |
+-------------------------------------+
		");
		
		$this->index();
		
	}
	
}
