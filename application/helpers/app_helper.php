<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	
function monetaryInput($number){
	return str_replace(",",".",str_replace(".","",$number));
}

function monetaryOutput($number){

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
	if(containsStr($menu,$_SERVER['REQUEST_URI'])){
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
	$meses = array(1 => 'Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
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

