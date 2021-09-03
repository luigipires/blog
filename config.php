<?php
	session_start();

	date_default_timezone_set('America/Sao_Paulo');

	define('HOST','localhost');
	define('USER','root');
	define('DATABASE','sistema_gestao');
	define('PASSWORD','');

	define('INCLUDE_PATH','http://localhost/funcionalidades/sistema_gestao/');
	define('INCLUDE_PATH_PAINEL',INCLUDE_PATH.'painel/');
	define('IMAGENS',__DIR__.'/painel/imagens/');

	$autoload = function($classe){
		include('classes/'.$classe.'.php');
	};

	spl_autoload_register($autoload);

	function destaque($destaque){
		$url = explode('/',@$_GET['url'])[0];

		if($url == $destaque){
			echo 'class="destaque"';
		}
	}

	function verificacaoPermissao($permissao1,$permissao2 = null){
		if($_SESSION['tipousuario'] == $permissao1 || $_SESSION['tipousuario'] == $permissao2){
			return;
		}else{
			echo 'style="display: none;"';
		}
	}

	function permissao($permissao1,$permissao2 = null){
		if($_SESSION['tipousuario'] == $permissao1 || $_SESSION['tipousuario'] == $permissao2){
			return;
		}else{
			include('painel/paginas/acesso-negado.php');
			die();
		}
	}
?>