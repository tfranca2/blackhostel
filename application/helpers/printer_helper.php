<?php

function printComanda($comanda, $username){
	
	$hasProtudos = count( $comanda->produtos) > 0;
	$handle = openBematechPrinter();
	
	printer_start_doc($handle, "Comanda");
	printer_start_page($handle);
	
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
	
	//$atualHeigth-=10;
	$font = printer_create_font("Calibri", 20, 20, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "____________________________", 30, $atualHeigth = $atualHeigth + $line);
	
	$line = 30;
	//*
	// COMANDA HEADER
	$font = printer_create_font("Calibri", 30, 30, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "Comanda: ". $comanda->id, 30, $atualHeigth = $atualHeigth + $line);
	
	// LINHA SEPARADORA
	$font = printer_create_font("Calibri", 20, 20, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "____________________________", 30, $atualHeigth = $atualHeigth + $line);
	
	
	$font = printer_create_font("Calibri", 30, 30, PRINTER_FW_BOLD, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "Reserva", 30, $atualHeigth = $atualHeigth + $line);
	//*
 	$font = printer_create_font("Calibri", 25, 25, PRINTER_FW_MEDIUM, false, false, false, 0);
 	printer_select_font($handle, $font);
	printer_draw_text($handle, "Entrada: ".$comanda->entrada , 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "Saída    : ".$comanda->saida, 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "Quarto : ".$comanda->numero.' '.$comanda->perfil, 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "Permanência : ".utf8_decode($comanda->permanencia), 30, $atualHeigth = $atualHeigth + $line);
	
	
	if($hasProtudos){
		// PRODUTOS
		$atualHeigth += 5;
		$font = printer_create_font("Calibri", 30, 30, PRINTER_FW_BOLD, false, false, false, 0);
		printer_select_font($handle, $font);
		printer_draw_text($handle, "Consumo", 30, $atualHeigth = $atualHeigth + $line);
		
		//*
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
	
	
	$font = printer_create_font("Calibri", 25, 25, PRINTER_FW_MEDIUM, false, false, false, 0);
	printer_select_font($handle, $font);
	if($hasProtudos)
	printer_draw_text($handle, "Total de Consumo:  ". 'R$ '. monetaryOutput($comanda->valorProdutos) , 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "Total Geral            :   ".'R$ '.monetaryOutput($comanda->total) , 30, $atualHeigth = $atualHeigth + $line);
	
	$atualHeigth+=15;
	$line = 20;
	$font = printer_create_font("Calibri", 15, 15, PRINTER_FW_MEDIUM, false, false, false, 0);
	printer_select_font($handle, $font);
	printer_draw_text($handle, "OBS: Esse cupom não possui valor fiscal nem", 30, $atualHeigth = $atualHeigth + $line);
	printer_draw_text($handle, "comprova pagamentos.", 30, $atualHeigth = $atualHeigth + $line);
	
	//*/
	printer_delete_font($font);
	
	printer_end_page($handle);
	printer_end_doc($handle);
	
	closeBematechPrinter($handle);
	die;
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

function openBematechPrinter(){
	$printerName = "MP-2500 TH";
	if($printer = @printer_open($printerName)){
		return $printer; 
	}else {
		print("Printer_helper could not open this printer:".$printerName);	
	}
}

function closeBematechPrinter($printer){
	@printer_close($printer);
}