<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reserva extends CI_Controller {

	const EM_USO = 1;
	const RESERVADO = 2;
	const MANUTENCAO = 3;
	const FINALIZADO = 4;
	const FECHADO = 5;
	const CANCELADO = 6;
    const SAIDA = 1;
    const ENTRADA = 2;

    public function __construct(){
		parent::__construct();
		$this->load->model('Login_model','login');
		$this->login->authorize();
		$this->load->helper(array('url','form','array','app','date','printer'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Quarto_model','quarto');
		$this->load->model('Reserva_model','reserva'); 
		
    }
	 

	public function index(){
		$this->load->view('index', array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'searching'
					,'tabledata'=>$this->reserva->getReservas()->result()
				));
	}
	
	public function searching(){
		
		$this->load->view('index',array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'searching'
					,'tabledata'=>$this->reserva->getReservas($this->input->post('id_sit'))->result()
				));
	}
	
	public function inserting(){
		$this->load->view('index', array(
					'page'=>'reserva'
					,'title'=> 'Reservas'
					,'part' => 'inserting'
					,'clientes'=>$this->db->get('cliente')->result()
					));
	}
	
	public function editing(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_reserva');
		$reserva = $this->reserva->getFullCurrentReservation($id);
		$quartos = $this->quarto->getAvailableBadroomsForEdition($reserva->tp_modo_reserva, $id, $reserva->entrada, $reserva->saida);
		
		$clientes = $this->reserva->getClientesFromReserva($id);
		
		$todos_clientes = $this->db->get('cliente')->result();
		if($id){
			$this->load->view('index', array(
						'page'=>'reserva'
						,'title'=> 'Reservas'
						,'part' => 'editing'
						,'reserva'=> $reserva
						,'quartos'=> $quartos
						,'clientes'=>$clientes
						,'todos_clientes'=>$todos_clientes
			));
		}else{
			$this->searching();
		}
	}

	public function deleting(){
		$id = $this->uri->segment(3) ? $this->uri->segment(3) : $this->input->post('id_reserva');
		$reserva = $this->reserva->getFullCurrentReservation( $id);
	
		$quartos = $this->quarto->getAvailableBadroomsForEdition($reserva->tp_modo_reserva, $id, $reserva->entrada, $reserva->saida);
		if($id){
			$this->load->view('index', array(
						'page'=>'reserva'
						,'title'=> 'Reservas'
						,'part' => 'deleting'
						,'quartos'=> $quartos
						,'reserva'=> $reserva));
		}else{
			$this->searching();
		}
	}
	
	public function save(){
		

		if (new DateTime(dateTimeToUs($this->input->post('saida'))) < new DateTime(dateTimeToUs($this->input->post('entrada')))) {
			$this->session->set_flashdata('msg', 'A Data Inicial não pode ser depois da Data Final');
			redirect('/reserva/inserting');
		}else{
		
			$this->form_validation->set_rules('entrada', 'Entrada', 'required');
			
			if ($this->runFormValidations() == TRUE){
			
				$dados = elements(array('id_quarto','entrada','saida','id_cliente'),$this->input->post());
				
				$dados['entrada'] = dateTimeToUs($dados['entrada']);
				$dados['saida'] = dateTimeToUs($dados['saida']);
				$dados['id_situacao'] =self::RESERVADO;
				
				$this->db->insert('reserva', $dados); 
				
				$last_id = $this->db->insert_id();
					
					
				foreach($this->input->post('clientes') as $cliente){
				
					$this->db->insert('reserva_cliente', array(
							'id_reserva' => $last_id,
							'id_cliente' => $cliente
					));
				}
				
				$this->load->view('index',array(
						'page'=>'reserva'
						,'title'=> 'Reservas'
						,'part' => 'inserting'
				));
				
				$this->session->set_flashdata('msg', 'Reserva registrada com sucesso.');
				redirect('/reserva');
				
			}else{
				$this->searching();
			}
		}
	}
	
	public function edit(){
		if ($this->runFormValidations() == TRUE){
			$id = $this->input->post('id_reserva');
			$reserva = $this->reserva->getFullCurrentReservation($id);
			
			$dados = elements(array('id_quarto','id_situacao','entrada','saida','id_cliente'),$this->input->post());
			if(empty($dados['id_cliente']))
				unset($dados['id_cliente']);
			
			$dados['entrada'] = dateTimeToUs($dados['entrada']);
			$dados['saida'] = dateTimeToUs($dados['saida']);
			
			$this->db->where('id_reserva', $id);
			$this->db->update('reserva', $dados);
			
			$this->db->where('id_reserva', $id);
			$this->db->delete('reserva_cliente'); 
			$clientes = $this->input->post('clientes');
			if($clientes){
				foreach($clientes as $cliente){
						
					$this->db->insert('reserva_cliente', array(
							'id_reserva' => $id,
							'id_cliente' => $cliente
					));
				}
			}
			
			$this->session->set_flashdata('msg', 'Reserva atualizada com sucesso.');
			$this->index();
			
		}else{
			$this->editing();
		}
	}

	public function ativar(){
		
			$id = $this->uri->segment(3);
			
			$dados['id_situacao'] =self::EM_USO;
			
			$this->db->where('id_reserva', $id);
			$this->db->update('reserva', $dados);
			
			$this->session->set_flashdata('msg', 'Reserva ativada com sucesso.');
			$this->index();
			
	}

	
	public function delete(){
		if($this->input->post('id_reserva')){
			$this->db->where('id_reserva', $this->input->post('id_reserva'));
			$this->db->delete('reserva'); 
			
			$this->session->set_flashdata('msg', 'Reserva deletada com sucesso.');
			$this->index();
		}else{
			$this->session->set_flashdata('msg', ":(");
			$this->index();
		}
		
	}
	
	private function runFormValidations(){
		
		$this->form_validation->set_rules('id_quarto', 'Quarto', 'required');
		
		return $this->form_validation->run() ;
	
	}
	
	public function quartos(){
		$entrada = dateTimeToUs( $this->input->get('entrada'));
		$saida   = dateTimeToUs( $this->input->get('saida'));
		$tipo = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		if($tipo){
			$quartos = $this->quarto->getAvailableBadroomsForEdition($tipo, $id, $entrada, $saida );
			echo json_encode($quartos);
		}
	}
	
	public function adicionar(){
		$dados['id_reserva'] = $this->input->post('reserva');
		$dados['id_produto'] = $this->input->post('produto');
		$dados['ativo'] = 1;
		if(isset($dados['id_reserva']) and isset($dados['id_produto'])){

		    $this->db->trans_begin();

            $this->db->select('id_reserva_produto, quantidade');
            $this->db->where('id_reserva', $dados['id_reserva']);
            $this->db->where('id_produto', $dados['id_produto']);
            $this->db->where('ativo', 1);
            $reserva_produto = $this->db->get('reserva_produto')->result();

            // verificar se o produto ja esta associado a reserva
            if( count($reserva_produto) > 0 and $reserva_produto[0]->id_reserva_produto > 0 ) {
                // se sim adicionar +1 a quantidade do produto
                $this->db->where('id_reserva_produto', $reserva_produto[0]->id_reserva_produto );
                $this->db->update('reserva_produto', array( 'quantidade' => ( $reserva_produto[0]->quantidade + 1 ) ) );
            } else {
                // se nao inserir a reserva
                $this->db->insert('reserva_produto',$dados);
            }

            $result = $this->db->query("  SELECT 
                                              qt_total 
                                          FROM estoque 
                                          WHERE id_produto = ". $dados['id_produto'] ." 
                                          ORDER BY id_estoque DESC 
                                          LIMIT 1   ")->row();
            $user = $this->session->get_userdata();

            if( $result != null and $result->qt_total > 0 ) {
                // removendo estoque do produto
                $this->db->insert('estoque', array(
                    'id_produto' => $dados['id_produto']
                , 'operacao' => self::SAIDA
                , 'qt_operacao' => 1
                , 'qt_total' => ( $result->qt_total - 1 )
                , 'id_usuario' => $user['user_session']['id_usuario']
                ));
            } else {
                $this->db->trans_rollback();
                echo json_encode(array('erro'=>'Estoque insuficiente!'));
            }

            $this->db->trans_commit();
		}
	}

	public function atualizaSaldoProduto() {

	    $dados['id_reserva'] = $this->input->post('reserva');
	    $dados['id_produto'] = $this->input->post('produto');
	    $dados['quantidade'] = $this->input->post('quantidade');
	    $dados['operacao']   = $this->input->post('operacao');

	    if( $dados['quantidade']==1 && $dados['operacao']==self::ENTRADA ){
            echo json_encode( array( 'erro' => 'A quantidade não pode ser 0!', 'quantidade' => $dados['quantidade'] ) );
            exit;
	    }

        if( isset($dados['id_reserva']) and isset($dados['id_produto']) ){

            try {
                // selecionando o estoque do produto
                $this->db->select('qt_total')
                        ->order_by('id_estoque',"DESC")
                        ->limit(1)
                        ->where('id_produto', $dados['id_produto']);
                $produto = $this->db->get('estoque')->result();


                if(
                    ( $produto[0]->qt_total > 0 )
                        or
                    ( $produto[0]->qt_total <= 0 and $dados['operacao'] == self::ENTRADA )
                ) {
                    // operaçao: 1 - debito de estoque/venda; 2 - credito de estoque/retorno;
                    $qt_comanda = $dados['quantidade'];
                    $qt_total = $produto[0]->qt_total;
                    switch( $dados['operacao'] ){
                        case self::SAIDA:$qt_total = $produto[0]->qt_total - 1; $qt_comanda += 1; break;
                        case self::ENTRADA:$qt_total = $produto[0]->qt_total + 1; $qt_comanda -= 1; break;
                    }

                    $user = $this->session->get_userdata();

                    $this->db->insert('estoque', array(
                          'id_produto' => $dados['id_produto']
                        , 'operacao' => $dados['operacao']
                        , 'qt_operacao' => 1
                        , 'qt_total' =>  $qt_total
                        , 'id_usuario' => $user['user_session']['id_usuario']
                    ));

                    // atualiza a quantidade na reserva
                    $this->db->where('id_produto', $dados['id_produto']);
                    $this->db->where('id_reserva', $dados['id_reserva']);
                    $this->db->update('reserva_produto', array('quantidade'=> $qt_comanda ));

                    echo json_encode( array( 'quantidade' => $qt_comanda ) );

                } else {
                    echo json_encode( array( 'erro' => 'Produto sem estoque suficiente!', 'quantidade' => $dados['quantidade'] ) );
                }

            } catch( Exception $e ) {
                echo json_encode( array( 'erro' => $e->getMessage(), 'quantidade' => $dados['quantidade'] ) );
            }
        }
    }

    public function remover(){
		$id = (int) $this->uri->segment(3);

		try {
            // selecionando o id e quantidade do produto adicionado a reserva
            $this->db->select('id_produto, quantidade');
            $this->db->where('id_reserva_produto', $id);
            $reserva_produto = $this->db->get('reserva_produto')->result();

            // selecionando o estoque do produto
            $this->db->select('qt_total')
                ->order_by('id_estoque',"DESC")
                ->limit(1)
                ->where( 'id_produto', $reserva_produto[0]->id_produto );
            $produto = $this->db->get('estoque')->result();

            // adicionando estoque do produto
            $user = $this->session->get_userdata();

            $this->db->insert('estoque', array(
                  'id_produto' => $reserva_produto[0]->id_produto
                , 'operacao' => self::ENTRADA
                , 'qt_operacao' => $reserva_produto[0]->quantidade
                , 'qt_total' => ( $produto[0]->qt_total + $reserva_produto[0]->quantidade )
                , 'id_usuario' => $user['user_session']['id_usuario']
            ));

            // deletando a tupla de reserva produto
            $this->db->where('id_reserva_produto', $id);
            $this->db->delete('reserva_produto');

            echo json_encode( array( 'exclusion' => true ) );

        } catch( Exception $e ) {
            echo json_encode( array( 'erro' => $e->getMessage(), 'exclusion' => false ) );
        }
    }

    public function atualizaOcupantes() {
        $dados['id_reserva'] = $this->input->post('reserva');
        $dados['quantidade'] = $this->input->post('quantidade');
        $dados['operacao']   = $this->input->post('operacao');

        $ocupantes = $dados['quantidade'];
        switch( $dados['operacao'] ) {
            case self::SAIDA: $ocupantes++; break;
            case self::ENTRADA: $ocupantes--; break;
        }

        if( $ocupantes <= 0 ) {
            echo json_encode(array('quantidade'=>1, 'erro'=>'Quantidade inválida!'));
            exit;
        }

        // atualiza a quantidade de ocupantes na reserva
        $this->db->where('id_reserva', $dados['id_reserva']);
        $this->db->update('reserva', array('qt_pessoas'=> $ocupantes ));

        echo json_encode(array('quantidade'=>$ocupantes));
    }

    public function adicionarFormaPagamentoReserva() {
        $id = $this->uri->segment(3);
        $this->db->insert('reserva_pagamento', array(
              'id_reserva' => $id
            , 'id_forma_pagamento' => 1
        ));
    }

    public function removerFormaPagamentoReserva() {
        $id = (int) $this->uri->segment(3);
        $this->db->where('id_reserva_pagamento', $id);
        $this->db->delete('reserva_pagamento');
    }

}
