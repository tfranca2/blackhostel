<?php

class Bematech_model extends CI_Model {

    private $socket;

    function __construct() {
        parent::__construct();
    }

    public function conecta( $endereco = null ) {
        $this->socket =  @fsockopen( $endereco,9100, $errno, $errstr, 1 );

        if( !$this->socket ) {
            echo "<b>$errno: $errstr!</b><br/>Falha na conex&atilde;o com a impressora!<br/><sub>( <b>$endereco:9100</b> )</sub>";
            exit;
        }

        fwrite( $this->socket, chr(27)."@" );
    }

    public function desconecta() {
        fclose( $this->socket );
    }

    ##########################################################
    ###  FALTANDO FUNÇÃO IMPRIMIR IMAGEM ( LOGO EMPRESA )  ###
    ##########################################################

    public function alinha( $align = "l" ) {
        switch( strtolower( $align ) ) {
            case "r":
            case "right":
            case "direita":
            case "d":
                $set = chr(50);
                break;
            case "center":
            case "centro":
            case "c":
                $set = chr(49);
                break;
            default:
                $set = chr(48);
        }

        fwrite( $this->socket, chr(27)."a".$set );
    }

    public function negrito( $texto ) {
        return chr(27)."E".$texto.chr(27)."F";
    }

    public function italico( $texto ) {
        return chr(27)."4".$texto.chr(27)."5";
    }

    public function sublinha( $texto ) {
        return chr(27)."-".chr(49).$texto.chr(27)."-".chr(48);
    }

    public function expandeTexto( $texto ) {
        return chr(27).chr(87).chr(49).$texto.chr(27).chr(87).chr(48);
    }

    public function condensaTexto( $texto ) {
        return chr(27).chr(15).$texto.chr(18);
    }

    public function escreve( $texto = "" ) {
		fwrite( $this->socket, $texto.chr(10) );
	}

    public function corta() {
        fwrite( $this->socket, chr(27)."m" );
    }

    public function geraCodigoDeBarras( $codigo ) {
                                            //  0 - sem legenda (HRI)
                                            //  1 - legenda superior
                                            //  2 - legenda inferior
                                            //  3 - legenda superior e inferior
		$posicaoCodigo = chr(29)."H".chr(0);
		$altura = chr(29)."h".chr(50);
		$largura = chr(29)."w".chr(10);
		$tamanho = strlen($codigo);
		// $m = chr(72);
		$n = chr( $tamanho );
		$imprimir = chr(29)."k"."I".$n.$codigo;

		return $posicaoCodigo.$altura.$largura.$imprimir;
	}

    public function geraQrCode($codigo ) {
		$tamanho = strlen($codigo);
		for($i=1;$i<=$tamanho;$i++){
			@$codido = $codido . chr(ord($codido[$i]));
		}
		if ($tamanho > 255){
             $cTam1 = $tamanho%255;
             $cTam2 = $tamanho/255;
		}
        else{
             $cTam1 = $tamanho;
             $cTam2 = 0;
        }

		return chr(27) . chr(97) . chr(1) . chr(29) . chr(107) . chr(81) .
                 chr(3) . chr(8) . chr(8) . chr(1) . chr($cTam1) . chr($cTam2) . $codigo;
	}
}

?>