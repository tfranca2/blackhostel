<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	
function monetaryInput($number){
	return str_replace(",",".",str_replace(".","",$number));
}

function monetaryOutput($number){
	$number =(double) str_replace(",",".",$number);
	$number = number_format($number, 2, '.', ''); 
	$pattern = '/([\d\.]+).([\d]{2})/';
	$replacementCent = '$1,$2';

	return preg_replace($pattern, $replacementCent, $number);
}

function dateTimeToBr($date){
	if($date)
	return date('d/m/Y H:i', strtotime($date));
}

function dateTimeToUs($date){
	if($date)
	return date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $date)));
}

function styleMenuActive($menu){
	if(containsStr( '\/'.$menu ,$_SERVER['REQUEST_URI'])){
		return 'active';
	}
}

function containsStr($str, $src){
	return (preg_match("/$str/",$src))?TRUE:FALSE;
}

function dump($var){
	echo '<pre>';	
	print_r($var);
	echo '</pre>';
}



function tagAs($tag, $var1, $var2){
	echo ($var1 == $var2)?$tag:''; 
}

function month($idx){
	$meses = array(1 => 'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	return $meses[$idx]; 
}

function extractMonths($data){
	$months ="";
	foreach ($data as $d){
		$months .= '\''.month($d->mes).'\', ';
	}
	return rtrim($months,', ');
}
function extractValues($data, $tipo){
	
	$values ='';
	foreach ($data as $d){
		if($tipo == $d->tipo_reserva ){	
			$values .=  $d->qtdmes.', ';
		}
	}
	return rtrim($values,', ');
}

function descModoReserva($id){
	if($id ==1){
		return 'Diárias';
	}else if($id == 2){
		return 'Horas';
	}else if($id == 3){
		return 'Pernoite';
	}
}

function calcularPrecoQuarto($resumoReserva, $diarias, $precoPerfil){
	if($resumoReserva->tipo == 1){
		return calculoDiaria($diarias, $precoPerfil, $resumoReserva);
	}elseif ($resumoReserva->tipo == 2){
		return calculoHora($precoPerfil, $resumoReserva);
	}elseif ($resumoReserva->tipo ==3){
		return calculoPernoite($diarias, $precoPerfil, $resumoReserva);
	}
}


/**
 * @param diarias
 * @param precoPerfil
 */
function calculoPernoite($diarias, $precoPerfil, $resumoReserva) {
	// tolerancia 
	if( $resumoReserva->horas>=22 and $resumoReserva->minutos>30 ){
		$precoQuarto = $precoPerfil*($diarias+1);
	}else{
		$precoQuarto = $precoPerfil*$diarias;
	}
	return $precoQuarto;		
}

/**
 * @param precoPerfil
 */
function calculoHora($precoPerfil, $resumoReserva) {
	// TOLERANCIAS
	if( $resumoReserva->minutos>30 ){
		$precoQuarto = $precoPerfil*($resumoReserva->horas+1);
	}elseif( $resumoReserva->minutos>15 ){
		$precoQuarto = $precoPerfil*($resumoReserva->horas+0.5);		
	}else{
		$precoQuarto = $precoPerfil*$resumoReserva->horas;
	}
	return $precoQuarto;
}

/**
 * @param diarias
 * @param precoPerfil
 */
function calculoDiaria($diarias, $precoPerfil, $resumoReserva) {
	 // TOLERANCIAS
	if( $resumoReserva->horaDia >= 14 and $resumoReserva->minutos>30 ){ // tolerancia diaria
		$precoQuarto = $precoPerfil * ( $diarias + 1 );
	}else{
		$precoQuarto = $precoPerfil * $diarias;
	}
	return $precoQuarto;
}





