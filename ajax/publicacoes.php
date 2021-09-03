<?php
	include('../config.php');

	if(Metodos::login() == false){
		Metodos::redirecionamentoespecifico(INCLUDE_PATH.'blog');
	}

	$data['sucesso'] = true;
	$data['mensagem'] = '';

	if(isset($_POST['acao-comentario'])){
		$comentario = $_POST['comentario'];

		sleep(1);

		if($comentario == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Campo vazio!';
		}else{
			$data['sucesso'] = true;
			$data['mensagem'] = 'Comentário enviado!';

			$sql = MySql::conexaobd()->prepare("INSERT INTO `comentarios` VALUES (null,?,?,?,?,?,?)");
			$sql->execute(array($_SESSION['id'],$_POST['noticia'],$comentario,0,0,0));
		}
	}else if(isset($_POST['acao-resposta'])){
		$resposta = $_POST['resposta'];

		sleep(1);

		if($resposta == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Campo vazio!';
		}else{
			$data['sucesso'] = true;
			$data['mensagem'] = 'Resposta enviada!';

			$sql = MySql::conexaobd()->prepare("INSERT INTO `respostas` VALUES (null,?,?,?,?,?,?,?,?)");
			$sql->execute(array($_SESSION['id'],$_POST['noticia-resposta'],$_POST['comentario-resposta'],0,$resposta,0,0,0));
		}
	}else if(isset($_POST['acao-resposta-resposta'])){
		$resposta = $_POST['resposta-resposta'];
		$idResposta = $_POST['value'];

		sleep(1);

		if($resposta == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = 'Campo vazio!';
		}else{
			$data['sucesso'] = true;
			$data['mensagem'] = 'Resposta enviada!';
			
			$sql = MySql::conexaobd()->prepare("INSERT INTO `respostas` VALUES (null,?,?,?,?,?,?,?,?)");
			$sql->execute(array($_SESSION['id'],$_POST['noticia-resposta-resposta'],$_POST['comentario-resposta-resposta'],$idResposta,$resposta,0,0,0));
		}
	}

	echo json_encode($data);
?>