<?php



function printComanda($comanda, $username){

//     var_dump($comanda);

//    $socket =  fsockopen( '192.168.9.100',9100, $errno, $errstr, 1 );
//    fwrite( $socket, chr(27)."@" );
//    fwrite( $socket, "texto de teste".chr(10) );
//    fwrite( $socket, chr(27)."m" );
//    fclose( $socket );

    $bema = new Bematech();
    $bema->conecta('192.168.9.100');
    $bema->escreve("Texto de teste");
//    $bema->corta();
    $bema->desconecta();

    /*/
	$hasProtudos = count( $comanda->produtos) > 0;
	$handle = openBematechPrinter();
	
	printer_start_doc($handle, "Comanda");
	printer_start_page($handle);
	
	$atualHeigth = 0;
	
	$atualHeigth = cabecalho( $handle, $atualHeigth );
	
	$line = 30;
	
	// COMANDA HEADER
	$font = printer_create_font("Calibri", 30, 30, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "Comanda: ". $comanda->id, 30, $atualHeigth = $atualHeigth + $line);
	
	$atualHeigth = linhaSeparadora( $handle, $atualHeigth, $line );

 	$font = printer_create_font("Calibri", 25, 25, PRINTER_FW_MEDIUM, false, false, false, 0);
 	printer_select_font($handle, $font);

 	printer_draw_text($handle, "Mesa : ".$comanda->numero, 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "Permanência : ".utf8_decode($comanda->permanencia), 30, $atualHeigth = $atualHeigth + $line);
	
	
	if($hasProtudos){
		// PRODUTOS
		$atualHeigth += 5;
		$font = printer_create_font("Calibri", 30, 30, PRINTER_FW_BOLD, false, false, false, 0);
		printer_select_font($handle, $font);
		printer_draw_text($handle, "Consumo", 30, $atualHeigth = $atualHeigth + $line);

		$font = printer_create_font("Calibri", 25, 25, PRINTER_FW_MEDIUM, false, true, false, 0);
		printer_select_font($handle, $font);
	
		$linelen = 25;
		
		foreach($comanda->produtos as $produto){
			printer_draw_text($handle, str_replace("-", " ", resolveLinha( utf8_decode($produto->produto).'-R$ '.$produto->preco,$linelen)) , 30, $atualHeigth = $atualHeigth + $line);
		}
	}
	
	$atualHeigth += 5;
	// TOTAIS
	$font = printer_create_font("Calibri", 30, 30, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "Totais", 30, $atualHeigth = $atualHeigth + $line);
	
	
	
	$font = printer_create_font( "Calibri", 25, 25, PRINTER_FW_MEDIUM, false, false, false, 0 );
	printer_select_font( $handle, $font );
	if( $hasProtudos )
	printer_draw_text( $handle, "Total de Consumo:           R$ ". monetaryOutput( $comanda->valorProdutos ), 30, $atualHeigth = $atualHeigth + $line );
	printer_draw_text( $handle, "Taxa de Atend. (10%):       R$ ". monetaryOutput( $comanda->total ), 30, $atualHeigth = $atualHeigth + $line );
	printer_draw_text( $handle, "Total Geral:                R$ ". monetaryOutput( $comanda->total ), 30, $atualHeigth = $atualHeigth + $line );
	
	$atualHeigth+=15;
	$line = 20;
	$font = printer_create_font("Calibri", 15, 15, PRINTER_FW_MEDIUM, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "OBS: Esse cupom não possui valor fiscal nem", 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "comprova pagamentos.", 30, $atualHeigth = $atualHeigth + $line);
	
	printer_delete_font($font);
	
	printer_end_page($handle);
	printer_end_doc($handle);
	
	closeBematechPrinter($handle);

	//*/
}

function printCaixa($cashMovmts, $username){

	$handle = openBematechPrinter();
	
	printer_start_doc($handle, "Comanda");
	printer_start_page($handle);

	$atualHeigth = 0;
	
	$atualHeigth = cabecalho( $handle, $atualHeigth );
	
	$line = 30;
	
	// COMANDA HEADER
	$font = printer_create_font("Calibri", 30, 30, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "Fechamento de Caixa ", 30, $atualHeigth = $atualHeigth + $line);
	
	$atualHeigth = linhaSeparadora( $handle, $atualHeigth, $line );

	// MOVIMENTA��ES
	$atualHeigth += 5;
	$font = printer_create_font("Calibri", 30, 30, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "Movimentações", 30, $atualHeigth = $atualHeigth + $line);
	
	//*
	$font = printer_create_font("Calibri", 20, 20, PRINTER_FW_MEDIUM, false, true, false, 0);
	printer_select_font($handle, $font);

	$linelen = 25;
	
	foreach($cashMovmts as $cash){
		$description = utf8_decode($cash->observacao);
		$fw = PRINTER_FW_MEDIUM;
		if(empty($description)){
			if($cash->operacao == 4){
				$description = "Fechamento de Caixa    ";
				printer_select_font($handle, $font);
				$fw = PRINTER_FW_BOLD;
			}else{
				 $description ="Mov. sem Descrição     ";				
			}
		}
		
		$font = printer_create_font("Calibri", 20, 20, $fw, false, true, false, 0);
		printer_select_font($handle, $font);
		printer_draw_text($handle, $description.' R$ '. monetaryOutput($cash->valor) , 30, $atualHeigth = $atualHeigth + $line);
	}
		
	$atualHeigth += 5;

	$font = printer_create_font("Calibri", 25, 25, PRINTER_FW_MEDIUM, false, false, false, 0);
	printer_select_font($handle, $font);

		$atualHeigth+=15;
		$line = 20;
		$font = printer_create_font("Calibri", 15, 15, PRINTER_FW_MEDIUM, false, false, false, 0);
		printer_select_font($handle, $font);

		//*/
		printer_delete_font($font);

		printer_end_page($handle);
		printer_end_doc($handle);

		closeBematechPrinter($handle);
}

function resolveLinha($texto, $len){
	if(strlen($texto) == $len){
		return $texto;
	}else{
		
		preg_match('/(-+)/', $texto, $re);
		$strs = explode(' - ', $re[1]);
		
		$strs  = str_replace($strs, $strs[0].'-', $texto);
		
		return resolveLinha($strs, $len);
	}
	
}


function cabecalho( $handle, $atualHeigth ) {
	$line = 40;
	$atualHeigth = 0;
	
	// HEADER                                                       <i>     <u>
	$font = printer_create_font("Calibri", 50, 30, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "  Pousada Sol Nascente   ", 0, 0);
	
	$atualHeigth+=25;
	$line = 20;
	
	$font = printer_create_font("Calibri", 20, 20, PRINTER_FW_MEDIUM, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "Av Chanceler Edson Queiroz 3321", 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "Data: ".date('d/m/Y H:i') , 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "CNPJ: 40.146.306/0001-75 " , 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "Atendente: ".utf8_decode( $username)  , 30, $atualHeigth = $atualHeigth + $line);
	
	return linhaSeparadora( $handle, $atualHeigth, $line );
}

function linhaSeparadora( $handle, $atualHeigth, $line ) {
	$atualHeigth = $atualHeigth + $line;
	
	printer_select_font( $handle, printer_create_font( "Calibri", 20, 20, PRINTER_FW_BOLD, false, false, false, 0 ) );
	printer_draw_text( $handle, "____________________________", 30, $atualHeigth );
	
	return $atualHeigth;
}


function openBematechPrinter(){
	// $printerName = "MP-2500 TH";
	$printerName = "192.168.1.157";
	if($printer = @printer_open($printerName)){
		return $printer; 
	}else {
		print("Printer_helper could not open this printer:".$printerName);	
	}
}

function closeBematechPrinter($printer){
	@printer_close($printer);
}