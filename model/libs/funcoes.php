<?php

    protegeArquivo(basename( __FILE__ ));
	
	session_start();
	
    define('BASE_URL','http://localhost/blackhostel/');
	date_default_timezone_set("America/Fortaleza");
	
    function protegeArquivo($nomeArquivo) {
        $url = strtoupper($_SERVER['PHP_SELF']);
		$nomeArquivo = strtoupper($nomeArquivo);
        if( strpos($url, $nomeArquivo) )
            header("Location: ".BASE_URL."index.php");
    }
    
    function criptografar($string){
        return md5($string);
    }
    
    function verificaLogin() {
        if(!$_SESSION['usuario_ativo'] )
			return false;
		else
			return true;
    }
	
	function incluiPagina($localdoarquivo) {
		if(file_exists($localdoarquivo)){
			require_once($localdoarquivo);
		}
	}
	
	function nomeMesPtBr($indice, $tipo){
		$mes = array(
			"Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", 
			"Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", 
			"Jul", "Ago", "Set", "Out", "Nov", "Dez"
		);
		return $mes[ ($tipo)?$indice-1:$indice+11 ];
	}
	
	function nomeDiaPtBr($indice, $tipo){
		$mes = array(
			"Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"
			, "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"
		);
		return $mes[ ($tipo)?$indice:$indice+7 ];
	}
	
	function alerta($msg){
		echo "<script type=\"text/javascript\">bootbox.alert(\"$msg\");</script> ";
	}
	
	function converteData($data){
		if(strstr($data, "/")){
			$data = explode('/', $data);
			@$dataNova = $data[2].'-'.$data[1].'-'.$data[0];
		}
		 else if(strstr($data, "-")){
			$data = explode('-', $data);
			@$dataNova = $data[2].'/'.$data[1].'/'.$data[0];
		}
		return @$dataNova;
    }
	
	function validateDate($date, $format = 'Y-m-d H:i:s') {
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	function backup($conexao) {
		$mysqlHostName = $conexao->getdb_host();
		$mysqlDatabaseName = $conexao->getdb_name();
		$mysqlUserName = $conexao->getdb_user();
		$mysqlPassword = $conexao->getdb_pass();
		
		$mysqlExportPath ='.\backups\backup_'.date('YmdHi').'.sql';
		
		$command='C:\xampp\mysql\bin\mysqldump.exe -u'.$mysqlUserName.' -p'.$mysqlPassword.' '.$mysqlDatabaseName.' > '.$mysqlExportPath;
		
		shell_exec($command);
	}
	
	function restore($conexao, $arquivo) {
		$mysqlHostName = $conexao->getdb_host();
		$mysqlDatabaseName = $conexao->getdb_name();
		$mysqlUserName = $conexao->getdb_user();
		$mysqlPassword = $conexao->getdb_pass();
				
		$command='C:\xampp\mysql\bin\mysql.exe -u'.$mysqlUserName.' -p'.$mysqlPassword.' '.$mysqlDatabaseName.' < '.$arquivo;
		
		shell_exec($command);
	}
?>
