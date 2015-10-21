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
	return date('d/m/Y H:i:s', strtotime($date));
}

function dateTimeToUs($date){
	if($date)
	return date('Y-m-d H:i:s', strtotime($date));
}

function styleMenuActive($menu){
	if(containsStr($menu,$_SERVER['REQUEST_URI'])){
		return 'active';
	}
}

function containsStr($str, $src){
	return (preg_match("/$str/",$src))?TRUE:FALSE;
}


