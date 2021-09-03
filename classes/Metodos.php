<?php
	class Metodos{
		public static function login(){
			return isset($_SESSION['login']) ? true : false;
		}

		public static function signout(){
			setcookie('lembrar-senha',true,time() - 1,'/');
			session_destroy();
			header('Location: '.INCLUDE_PATH);
		}

		public static function redirecionamento(){
			Header('Location: '.INCLUDE_PATH_PAINEL);
			die();
		}

		public static function redirecionamentoEspecifico($url){
			echo '<script>location.href="'.$url.'"</script>';
			die();
		}

		public static function carregarpagina(){
			if(isset($_GET['url'])){
				$url = explode('/',$_GET['url']);

				if(file_exists('paginas/'.$url[0].'.php')){
					include('paginas/'.$url[0].'.php');
				}else{
					include('paginas/erro.php');
				}
			}else{
				include('paginas/pagina-inicial.php');
			}
		}

		public static function mensagem($resposta,$mensagem){
			if($resposta == 'sucesso'){
				echo '<div class="sucesso-mensagem"><i class="fas fa-check-circle"></i><p>'.$mensagem.'</p></div>';
			}else if($resposta == 'erro'){
				echo '<div class="erro-mensagem"><i class="fas fa-exclamation-triangle"></i><p>'.$mensagem.'</p></div>';
			}else if($resposta == 'alerta'){
				echo '<div class="alerta-mensagem"><i class="fas fa-exclamation-circle"></i><p>'.$mensagem.'</p></div>';
			}
		}

		public static $tipousuario = [
			'0' => 'Usuário',
			'1' => 'Moderador',
			'2' => 'Administrador'
		];

		public static function gerarurl($url){
			$url = mb_strtolower($url);
			$url = preg_replace('/(á|à|ã)/', 'a', $url);
			$url = preg_replace('/(ê|é)/', 'e', $url);
			$url = preg_replace('/(í)/', 'i', $url);
			$url = preg_replace('/(ó|ô|õ|ö)/', 'o', $url);
			$url = preg_replace('/(ú)/', 'u', $url);
			$url = preg_replace('/(ç)/', 'c', $url);
			$url = preg_replace('/( )/', '-', $url);
			$url = preg_replace('/(_|\/|!|\?|#)/', '', $url);
			$url = preg_replace('/([-]{1,})/', '-', $url);
			$url = preg_replace('/(,)/', '-', $url);
			$url = strtolower($url);
			
			return $url;
		}

		public static function validacaoimagem($imagem){
			if($imagem['type'] == 'image/jpg' || $imagem['type'] == 'image/png' || $imagem['type'] == 'image/jpeg'){
				$tamanhoimagem = intval($imagem['size']/3056);

				if($tamanhoimagem < 700){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		public static function uparimagemusuario($arquivo){
			$formatoarquivo = explode('.',$arquivo['name']);
			$arquivonome = uniqid().'.'.$formatoarquivo[count($formatoarquivo) - 1];

			if(move_uploaded_file($arquivo['tmp_name'],IMAGENS.'usuarios/'.$arquivonome)){
				return $arquivonome;
			}else{
				return false;
			}
		}

		public static function apagarimagemusuario($imagem){
			@unlink('imagens/usuarios/'.$imagem);
		}

		public static function uparimagembanner($arquivo){
			$formatoarquivo = explode('.',$arquivo['name']);
			$arquivonome = uniqid().'.'.$formatoarquivo[count($formatoarquivo) - 1];

			if(move_uploaded_file($arquivo['tmp_name'],IMAGENS.'banners/'.$arquivonome)){
				return $arquivonome;
			}else{
				return false;
			}
		}

		public static function apagarimagembanner($imagem){
			@unlink('imagens/banners/'.$imagem);
		}

		public static function uparimagemavaliacao($arquivo){
			$formatoarquivo = explode('.',$arquivo['name']);
			$arquivonome = uniqid().'.'.$formatoarquivo[count($formatoarquivo) - 1];

			if(move_uploaded_file($arquivo['tmp_name'],IMAGENS.'avaliacoes/'.$arquivonome)){
				return $arquivonome;
			}else{
				return false;
			}
		}

		public static function apagarimagemavaliacao($imagem){
			@unlink('imagens/avaliacoes/'.$imagem);
		}

		public static function uparimagemnoticia($arquivo){
			$formatoarquivo = explode('.',$arquivo['name']);
			$arquivonome = uniqid().'.'.$formatoarquivo[count($formatoarquivo) - 1];

			if(move_uploaded_file($arquivo['tmp_name'],IMAGENS.'noticias/'.$arquivonome)){
				return $arquivonome;
			}else{
				return false;
			}
		}

		public static function apagarimagemnoticia($imagem){
			@unlink('imagens/noticias/'.$imagem);
		}

		public static function recuperarcampopreenchido($post){
			if(isset($_POST[$post])){
				echo $_POST[$post];
			}
		}

		public static function buscarinformacoes($tabela,$comecar = null,$terminar = null,$id = null){
			if($comecar == null && $terminar == null && $id == null){
				$sql = MySql::conexaobd()->prepare("SELECT * FROM `$tabela`");
				$sql->execute();
			}else if($comecar == null && $terminar == null && $id != null){
				$sql = MySql::conexaobd()->prepare("SELECT * FROM `$tabela` WHERE id != ?");
				$sql->execute(array($id));
			}else{
				$sql = MySql::conexaobd()->prepare("SELECT * FROM `$tabela` WHERE id != ? LIMIT $comecar,$terminar");
				$sql->execute(array($id));
			}

			return $sql->fetchAll();
		}

		public static function buscarinformacoesPrincipal($tabela,$comecar = null,$terminar = null){
			if($comecar == null && $terminar == null){
				$sql = MySql::conexaobd()->prepare("SELECT * FROM `$tabela`");
				$sql->execute();
			}else{
				$sql = MySql::conexaobd()->prepare("SELECT * FROM `$tabela` LIMIT $comecar,$terminar");
				$sql->execute();
			}

			return $sql->fetchAll();
		}

		public static function carregarjavascript($arquivo,$paginas){
			$url = explode('/',@$_GET['url'])[0];

			if($paginas == $url){
				foreach ($arquivo as $key => $value){
					echo '<script src="'.INCLUDE_PATH.'javascript/'.$value.'"></script>';
				}
			}
		}
	}
?>
