<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comanda extends CI_Controller {
	
	public $_precoQuarto = 0;
	public $_precoPerfil = 0;
	public $_precoItens = 0;
	public $_precoProdutos = 0;
	public $_precoValorTotal = 0;
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','array','app','printer'));
		$this->load->library(array('form_validation','session'));
		$this->load->database();
		$this->load->model('Login_model','login');
		$this->load->model('Perfil_model','perfil');
		$this->load->model('Reserva_model','reserva');
		$this->load->model('Comanda_model','comanda');
		$this->load->model('Bematech_model','impressora');
		$this->login->authorize();
    }
	 
	public function index(){
		
		$sql = "SELECT 
					re.id_reserva ,
					re.entrada,
					re.saida,
					qt.numero ,
					pf.descricao as perfil ,
					pf.tp_modo_reserva AS tipo ,
					pf.preco_base AS valor_perfil ,
					(SELECT SUM(it.preco) FROM perfil_item pit 
						LEFT JOIN item it 
							ON pit.id_item = it.id_item 
						WHERE pf.id_perfil = pit.id_perfil AND pf.id_perfil = qt.id_perfil) 
						AS valor_itens,		
					(SELECT SUM(pt.preco) FROM reserva_produto rpt 
						LEFT JOIN produto pt 
							ON rpt.id_produto = pt.id_produto and rpt.ativo = 1
						WHERE re.id_reserva = rpt.id_reserva) 
						AS valor_produtos

				FROM reserva re

				inner JOIN quarto qt 
					ON re.id_quarto = qt.id_quarto
				inner JOIN perfil pf 
					ON qt.id_perfil = pf.id_perfil
				where re.id_situacao not in (2,3,5,6)
				ORDER BY re.id_reserva DESC
				";
		
		$tabledata = $this->db->query($sql)->result();
		
		$this->load->view('index', array(
					'page'=>'comanda'
					,'title'=> 'Comandas'
					,'part' => 'searching'
					,'tabledata'=>$tabledata
					,'produtos'=>$this->db->query("SELECT * FROM produto WHERE estoque > 0")->result()
				));
	}
	
	public function searching(){
		$sql = "SELECT re.id_reserva as id_reserva, pf.descricao as perfil,  qt.numero as numero, IF(pf.tp_modo_reserva=1,'D', IF(pf.tp_modo_reserva=2,'H', IF(pf.tp_modo_reserva=3,'P',	pf.tp_modo_reserva))) AS tipo  FROM reserva re LEFT JOIN quarto qt ON re.id_quarto = qt.id_quarto inner JOIN perfil pf ON qt.id_perfil = pf.id_perfil WHERE re.id_situacao not in (2,3,5,6) AND qt.numero like '%".$this->input->get('numero')."%'";
		
		$this->load->view('index',array(
					'page'=>'comanda'
					,'title'=> 'Comandas'
					,'part' => 'searching'
					,'tabledata'=>$this->db->query($sql)->result()
				));
	}
	
	public function detail(){
		$id = (int) $this->uri->segment(3);
		
		$dados['saida'] = dateTimeToUs(date('Y-m-d H:i:s'));
			
		$this->db->where('id_reserva', $id);
		$this->db->update('reserva', $dados);
		
		echo ($this->buildDetail());
	}
		
	public function buildDetail(){
	
		$id = (int) $this->uri->segment(3);
		
		$this->calcularPreco($id);
		
		$sql = "SELECT 
					re.entrada, 
					re.saida, 
					TIMESTAMPDIFF( DAY, re.entrada, re.saida ) AS dias , 
					TIMESTAMPDIFF( HOUR, re.entrada, re.saida ) AS horas, 
					TIMESTAMPDIFF( MINUTE, re.entrada + INTERVAL TIMESTAMPDIFF(HOUR, re.entrada, re.saida) HOUR, re.saida ) AS minutos, 
					qt.numero, 
					pf.descricao AS perfil, 
					pf.tp_modo_reserva AS tipo 
				FROM reserva re 
				LEFT JOIN quarto qt 
					ON re.id_quarto = qt.id_quarto 
				LEFT JOIN perfil pf 
					ON qt.id_perfil = pf.id_perfil 
				WHERE re.id_reserva = ".$id;
				
		$result = $this->db->query($sql)->row();
		
		$quarto = $result->numero;
		$perfil = $result->perfil;
		$entrada = $result->entrada;
		$saida = date('Y-m-d H:i:s');
		$saida = $result->saida;
		$ocupantes = $this->reserva->getTotalClientsPerReservation($id)->total;
		if( $result->tipo == 1 ){
			$permanencia = ((!$result->dias)?1:$result->dias).' Diária(s)';
		} elseif( $result->tipo == 2 ){
			$permanencia = $result->horas.':'.$result->minutos.' Hrs';
		} elseif( $result->tipo == 3 ){
			$permanencia = ((!$result->dias)?1:$result->dias).' Pernoite(s)';
		}
		
		//fazer lista de produtos para a view
	    $s = "SELECT rpt.id_reserva_produto, produto, preco FROM produto pt inner JOIN reserva_produto rpt ON rpt.id_produto = pt.id_produto and rpt.ativo = 1 WHERE rpt.id_reserva = ".$id;
		 $produtos = $this->db->query($s)->result_array();
		
		  return json_encode(
					array(
						 "id"=>$id
						,"numero"=> $quarto
						,"perfil"=>$perfil
						,"entrada"=>dateTimeToBr($entrada)
						,"saida"=>dateTimeToBr($saida)
						,"permanencia"=>$permanencia
						,"ocupantes"=>$ocupantes
						,"produtos"=>$produtos
						,"precoPerfil"=> monetaryOutput($this->_precoPerfil)
						,"precoQuarto"=> monetaryOutput($this->_precoQuarto)
						,"valorProdutos"=> monetaryOutput($this->_precoProdutos)
						,"total"=>monetaryOutput($this->_precoValorTotal) 
					));
	}
	
	public function finalizar(){
		
		$id = (int) $this->uri->segment(3);
		
		$user = $this->session->get_userdata();
		$id_usuario = $user['user_session']['id_usuario'];
		$data = date("Y-m-d H:i:s");
		
		$this->calcularPreco($id);
		
		$dados['valor'] = $this->_precoValorTotal;
		$dados['operacao'] = 5; //venda
		$dados['observacao'] = "Venda ref. à reserva $id";
		$dados['id_usuario'] = $id_usuario;
		$dados['data'] = $data;
		
		$this->db->insert('caixa', $dados);
		
		$this->db->where('id_reserva', $id);
		$this->db->update('reserva', array('id_situacao'=>5));
		
		$this->imprimir();
				
		redirect('/comanda/');
		
	}
	
	public function calcularPreco($id){
	
		$resumoReserva = $this->comanda->getResumoReserva($id);
		
		$precoPessoaPerfil   = $this->perfil->getPriceForClients($resumoReserva->id_perfil);
		
		$totalClientesReserva= $this->reserva->getTotalClientsPerReservation($id);
		
		$totalClientes = ($totalClientesReserva->total -1);
		
		$diarias = (!$resumoReserva->dias)?1:$resumoReserva->dias;
	
		if($resumoReserva->tipo == 2){
			$precoPerfil = $resumoReserva->valor_perfil + $resumoReserva->valor_itens;
		}else{
			$precoPerfil = $precoPessoaPerfil[$totalClientes]['preco'] + $resumoReserva->valor_itens;
		}
			
		 $precoQuarto = calcularPrecoQuarto ($resumoReserva, $diarias, $precoPerfil);
		
		$total = $precoQuarto+$resumoReserva->valor_produtos;
		
		$this->_precoQuarto = $precoQuarto;
		$this->_precoPerfil = $precoPerfil;
		$this->_precoProdutos = $resumoReserva->valor_produtos;
		$this->_precoValorTotal = $total;
		
	}
	

	
	
	public function imprimir(){
		$user = $this->session->get_userdata();
		$username = $user['user_session']['nome'];
		$comanda = json_decode($this->buildDetail());

//		var_dump($comanda);

        $this->impressora->conecta('192.168.9.100');

        $this->impressora->alinha("center");

        $this->impressora->escreve(
            $this->impressora->expandeTexto(
                $this->impressora->italico( "Pousada Sol Nascente" )
            )
        );

        $this->impressora->escreve( "Av. Chanceler Edson Queiroz, 3321\nCohab, Cascavel - CE" );
        $this->impressora->escreve( "Tel.: (85) 9 8765-4321 - CNPJ.: 40.146.306/0001-75" );
        $this->impressora->escreve( date("d/m/Y H:i")
            . str_pad( "Atend.: ". strtoupper( tiraAcento( $username ) ),34,' ',STR_PAD_LEFT) );

        $this->impressora->escreve(
            $this->impressora->negrito( "\nSEM VALOR FISCAL / NAO COMPROVA PAGAMENTO\n" )
        );
        $this->impressora->escreve( " Mesa ".$comanda->numero."                    Permanencia: ". $comanda->permanencia );
        $this->impressora->escreve( "Comanda ".$comanda->id
//            .$this->impressora->geraCodigoDeBarras( $comanda->id )
        );

        $this->impressora->alinha("left");

        $this->impressora->escreve( $this->impressora->sublinha( "ITEM DESCRICAO        QTD  VL. ITEM    SUB TOTAL " ));

        $couvert = 15.00;
        $soma = 0;
        $i = 0;
        foreach( $comanda->produtos as $produto ) {
            $i++;
            $this->impressora->escreve( str_pad($i,2,'0',STR_PAD_LEFT)." - ".str_pad( strtoupper( tiraAcento( $produto->produto ) ) ,15,' ')."  ".str_pad('1',2,'0',STR_PAD_LEFT)."   R$ ". number_pad( monetaryOutput( $produto->preco ), 6 ) ."   R$ ". number_pad( monetaryOutput( $produto->preco ), 8 )  );
            $soma += $produto->preco;
        }
        $this->impressora->escreve( $this->impressora->sublinha( "                                                  " ) );
        $this->impressora->escreve( "Total consumo:                         R$ ". number_pad( monetaryOutput( $soma ), 8 ) );
        $this->impressora->escreve( "Taxa de Atendimento (10%):             R$ ".number_pad(monetaryOutput( $soma*0.1), 8 ) );
        $this->impressora->escreve( "Couvert Artistico:    ".str_pad($comanda->ocupantes,2,'0',STR_PAD_LEFT)."   R$ ".number_pad( monetaryOutput( $couvert ), 5 )."    R$ ". number_pad(monetaryOutput( $couvert*$comanda->ocupantes), 8 ) );
        $this->impressora->escreve(
            $this->impressora->negrito(
                $this->impressora->sublinha( "Valor a Pagar:                         R$ ".number_pad(monetaryOutput(  $soma + ($soma*0.1) + ($couvert*$comanda->ocupantes) ), 8 ) )
            )
        );

        $this->impressora->alinha("center");
        $this->impressora->escreve( "\nObrigado pela preferencia.\nVOLTE SEMPRE!" );
//        $this->impressora->escreve( "Visite nosso site!".$this->impressora->geraQrCode( 'http://www.pousadasolnascente.com.br/' ) );
        $this->impressora->corta();
        $this->impressora->desconecta();

    }
}
