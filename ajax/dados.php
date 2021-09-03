<?php
	include('../config.php');

	$data['sucesso'] = true;
	$data['mensagem'] = '';

	$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios`");
	$sql->execute();
	$sql = $sql->fetch();

	if(isset($_POST['acao-login'])){
		$email = $_POST['email-login'];
		$senha = $_POST['password-login'];

		sleep(3);

		if($email == '' || filter_var($email,FILTER_VALIDATE_EMAIL) == false){
			$data['sucesso'] = false;
			$data['mensagem'] = 'E-mail inválido!';
		}else if($senha == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = 'A senha não foi inserida!';
		}else{
			$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE email = ? AND senha = MD5(?)");
			$sql->execute(array($email,$senha));

			if($sql->rowCount() == 1){
				$data['sucesso'] = true;
				$sql = $sql->fetch();
				$_SESSION['login'] = true;
				$_SESSION['email'] = $sql['email'];
				$_SESSION['id'] = $sql['id'];
				$_SESSION['nome'] = $sql['nome'];
				$_SESSION['sobrenome'] = $sql['sobrenome'];
				$_SESSION['foto_usuario'] = $sql['foto_usuario'];
				$_SESSION['tipousuario'] = $sql['tipo_usuario'];

				if(isset($_POST['lembrar'])){
					setcookie('lembrar',true,time()+(60 * 5),'/');
					setcookie('email-login',$email,time()+(60 * 5),'/');
					setcookie('password-login',$senha,time()+(60 * 5),'/');
				}
			}else{
				$data['sucesso'] = false;
				$data['mensagem'] = 'E-mail ou senha incorretos!';
			}
		}
	}else if(isset($_POST['acao-contato'])){
		$nome = $_POST['nome-contato'];
		$email = $_POST['email-contato'];
		$mensagem = $_POST['mensagem-contato'];

		sleep(2);

		if($nome == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Você precisa inserir seu nome!';
		}else if($email == '' || filter_var($email,FILTER_VALIDATE_EMAIL) == false){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Você precisa inserir um e-mail válido!';
		}else if($mensagem == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Você precisa criar uma mensagem!';
		}else{
			//phpmailer
			$data['sucesso'] = true;
			$data['mensagem'] = 'Deu certo!';
		}
	}else if(isset($_POST['acao-cadastro'])){
		$nome = $_POST['nome-cadastro'];
		$sobrenome = $_POST['sobrenome-cadastro'];
		$email = $_POST['email-cadastro'];
		$senha = $_POST['password-cadastro'];
		$tipousuario = $_POST['tipo-usuario'];

		sleep(2);

		if($nome == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Nome não inserido!';
		}else if($sobrenome == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Sobrenome não inserido!';
		}else if($email == '' || filter_var($email,FILTER_VALIDATE_EMAIL) == false || $email == $sql['email']){
			$data['sucesso'] = false;
			$data['mensagem'] = 'E-mail inválido/existente!';
		}else if($senha == '' || !preg_match('/^(?=.*\d)(?=.*[A-Z])[0-9A-Za-z-_.!@#%?]{8,}$/',$senha)){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Senha com caracteres inválidos!';
		}else{
			if(isset($_FILES['foto'])){
				if(Metodos::validacaoimagem($_FILES['foto']) == false){
					$foto = '';
					$data['sucesso'] = false;
					$data['mensagem'] = 'A imagem não é válida!';
				}else{
					$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE email = ?");
					$sql->execute(array($email));

					if($sql->rowCount() == 0){
						$foto = Metodos::uparimagemusuario($_FILES['foto']);
						$cadastro = MySql::conexaobd()->prepare("INSERT INTO `usuarios` VALUES(null,?,?,?,?,?,?)");
						$cadastro->execute(array($nome,$sobrenome,$email,md5($senha),$foto,$tipousuario));
						$data['sucesso'] = true;
						$data['mensagem'] = 'Cadastro com foto!';
					}else{
						$data['sucesso'] = false;
						$data['mensagem'] = 'Já existe um cadastro com esse e-mail!';
					}			
				}
			}else{
				$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE email = ?");
				$sql->execute(array($email));

				if($sql->rowCount() == 0){
					$cadastro = MySql::conexaobd()->prepare("INSERT INTO `usuarios` VALUES(null,?,?,?,?,?,?)");
					$cadastro->execute(array($nome,$sobrenome,$email,md5($senha),0,$tipousuario));
					$data['sucesso'] = true;
					$data['mensagem'] = 'Cadastro sem foto!';
				}else{
					$data['sucesso'] = false;
					$data['mensagem'] = 'Já existe um cadastro com esse e-mail!';
				}
			}
		}
	}

	die(json_encode($data));
?>