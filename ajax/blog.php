<?php
	include('../config.php');

	if(Metodos::login() == false){
		Metodos::redirecionamentoespecifico(INCLUDE_PATH);
	}

	$data = '';

	//contar likes e inserir, ou atualizar, ação dada pelo usuário
	if(isset($_POST['idLike']) && $_POST['idLike'] == 'like'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaLike'];
		$comentario = $_POST['comentarioLike'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
		$contagem->execute(array($comentario));
		$contagem = $contagem->fetch();

		$numero = $contagem['comentario_like'];
		$numero = $numero+1;

		/****************************************/
		// inserindo na tabela de feedback

		$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_comentarios` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ?");
		$informacaoFeedback->execute(array($usuario,$noticia,$comentario));

		if($informacaoFeedback->rowCount() == 1){
			$informacaoFeedback = $informacaoFeedback->fetch();

			if($informacaoFeedback['comentario_deslike'] == 1){
				$feedback = MySql::conexaobd()->prepare("UPDATE `feedback_comentarios` SET comentario_like = ?, comentario_deslike = ? WHERE id = ?");
				$feedback->execute(array(1,0,$informacaoFeedback['id']));

				$recontagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
				$recontagem->execute(array($comentario));
				$recontagem = $recontagem->fetch();

				$numeroLike = $recontagem['comentario_like'];
				$numeroLike = $numeroLike + 1;

				$numeroDeslike = $recontagem['comentario_deslike'];
				$numeroDeslike = $numeroDeslike - 1;

				$sql = MySql::conexaobd()->prepare("UPDATE `comentarios` SET comentario_like = ?, comentario_deslike = ? WHERE id = ?");
				$sql->execute(array($numeroLike,$numeroDeslike,$comentario));

				/*************************************************/

				$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
				$contagem->execute(array($comentario));
				$contagem = $contagem->fetch();

				$data.='
						<button action="'.INCLUDE_PATH.'ajax/blog.php" no-like noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" title="Like">
							<h3><i class="fas fa-thumbs-up"></i></h3>
							<p>'.$contagem['comentario_like'].'</p>
						</button>
						<button deslike noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" title="Deslike">
							<h3><i class="fas fa-thumbs-down"></i></h3>
							<p>'.$contagem['comentario_deslike'].'</p>
						</button>'
				;
			}
		}else{
			$feedback = MySql::conexaobd()->prepare("INSERT INTO `feedback_comentarios` VALUES (null,?,?,?,?,?)");
			$feedback->execute(array($usuario,$noticia,$comentario,1,0));

			$sql = MySql::conexaobd()->prepare("UPDATE `comentarios` SET comentario_like = ? WHERE id = ?");
			$sql->execute(array($numero,$comentario));

			/*************************************************/

			$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
			$contagem->execute(array($comentario));
			$contagem = $contagem->fetch();

			$data.='
					<button action="'.INCLUDE_PATH.'ajax/blog.php" no-like craveLike="'.$_SESSION['id'].'" noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" title="Like">
						<h3><i class="fas fa-thumbs-up"></i></h3>
						<p>'.$contagem['comentario_like'].'</p>
					</button>
					<button deslike noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" title="Deslike">
						<h3><i class="fas fa-thumbs-down"></i></h3>
						<p>'.$contagem['comentario_deslike'].'</p>
					</button>'	
			;
		}
	}

	//tirar like
	if(isset($_POST['idNoLike']) && $_POST['idNoLike'] == 'no-like'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaLike'];
		$comentario = $_POST['comentarioLike'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
		$contagem->execute(array($comentario));
		$contagem = $contagem->fetch();

		$numero = $contagem['comentario_like'];
		$numero = $numero - 1;

		/****************************************/
		// deletar da tabela de feedback

		$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_comentarios` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ?");
		$informacaoFeedback->execute(array($usuario,$noticia,$comentario));
		$informacaoFeedback = $informacaoFeedback->fetch();

		$feedback = MySql::conexaobd()->prepare("DELETE FROM `feedback_comentarios` WHERE id = ?");
		$feedback->execute(array($informacaoFeedback['id']));

		$sql = MySql::conexaobd()->prepare("UPDATE `comentarios` SET comentario_like = ? WHERE id = ?");
		$sql->execute(array($numero,$comentario));

		/*************************************************/

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
		$contagem->execute(array($comentario));
		$contagem = $contagem->fetch();

		$data.='
				<button action="'.INCLUDE_PATH.'ajax/blog.php" like noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" title="Like">
					<h3><i class="fas fa-thumbs-up"></i></h3>
					<p>'.$contagem['comentario_like'].'</p>
				</button>
				<button deslike noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" title="Deslike">
					<h3><i class="fas fa-thumbs-down"></i></h3>
					<p>'.$contagem['comentario_deslike'].'</p>
				</button>	
		';
	}

	//contar deslikes e inserir, ou atualizar, ação dada pelo usuário
	if(isset($_POST['idDeslike']) && $_POST['idDeslike'] == 'deslike'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaDeslike'];
		$comentario = $_POST['comentarioDeslike'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
		$contagem->execute(array($comentario));
		$contagem = $contagem->fetch();

		$numero = $contagem['comentario_deslike'];
		$numero = $numero+1;

		/****************************************/
		// inserindo na tabela de feedback

		$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_comentarios` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ?");
		$informacaoFeedback->execute(array($usuario,$noticia,$comentario));

		if($informacaoFeedback->rowCount() == 1){
			$informacaoFeedback = $informacaoFeedback->fetch();

			if($informacaoFeedback['comentario_like'] == 1){
				$feedback = MySql::conexaobd()->prepare("UPDATE `feedback_comentarios` SET comentario_like = ?, comentario_deslike = ? WHERE id = ?");
				$feedback->execute(array(0,1,$informacaoFeedback['id']));

				$recontagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
				$recontagem->execute(array($comentario));
				$recontagem = $recontagem->fetch();

				$numeroLike = $recontagem['comentario_like'];
				$numeroLike = $numeroLike - 1;

				$numeroDeslike = $recontagem['comentario_deslike'];
				$numeroDeslike = $numeroDeslike + 1;

				$sql = MySql::conexaobd()->prepare("UPDATE `comentarios` SET comentario_like = ?, comentario_deslike = ? WHERE id = ?");
				$sql->execute(array($numeroLike,$numeroDeslike,$comentario));

				/*************************************/

				$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
				$contagem->execute(array($comentario));
				$contagem = $contagem->fetch();

				$data.='
						<button action="'.INCLUDE_PATH.'ajax/blog.php" like noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" title="Like">
							<h3><i class="fas fa-thumbs-up"></i></h3>
							<p>'.$contagem['comentario_like'].'</p>
						</button>
						<button no-deslike noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" title="Deslike">
							<h3><i class="fas fa-thumbs-down"></i></h3>
							<p>'.$contagem['comentario_deslike'].'</p>
						</button>
				';
			}
		}else{
			$feedback = MySql::conexaobd()->prepare("INSERT INTO `feedback_comentarios` VALUES (null,?,?,?,?,?)");
			$feedback->execute(array($usuario,$noticia,$comentario,0,1));

			$sql = MySql::conexaobd()->prepare("UPDATE `comentarios` SET comentario_deslike = ? WHERE id = ?");
			$sql->execute(array($numero,$comentario));

			/*************************************/

			$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
			$contagem->execute(array($comentario));
			$contagem = $contagem->fetch();

			$data.='
					<button action="'.INCLUDE_PATH.'ajax/blog.php" like noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" title="Like">
						<h3><i class="fas fa-thumbs-up"></i></h3>
						<p>'.$contagem['comentario_like'].'</p>
					</button>
					<button no-deslike noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" title="Deslike">
						<h3><i class="fas fa-thumbs-down"></i></h3>
						<p>'.$contagem['comentario_deslike'].'</p>
					</button>
			';
		}
	}

	//tirar deslike
	if(isset($_POST['idNoDeslike']) && $_POST['idNoDeslike'] == 'no-deslike'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaDeslike'];
		$comentario = $_POST['comentarioDeslike'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
		$contagem->execute(array($comentario));
		$contagem = $contagem->fetch();

		$numero = $contagem['comentario_deslike'];
		$numero = $numero - 1;

		/****************************************/
		//deletando da tabela de feedback

		$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_comentarios` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ?");
		$informacaoFeedback->execute(array($usuario,$noticia,$comentario));
		$informacaoFeedback = $informacaoFeedback->fetch();

		$feedback = MySql::conexaobd()->prepare("DELETE FROM `feedback_comentarios` WHERE id = ?");
		$feedback->execute(array($informacaoFeedback['id']));
		
		$sql = MySql::conexaobd()->prepare("UPDATE `comentarios` SET comentario_deslike = ? WHERE id = ?");
		$sql->execute(array($numero,$comentario));

		/*************************************/

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
		$contagem->execute(array($comentario));
		$contagem = $contagem->fetch();

		$data.='
				<button action="'.INCLUDE_PATH.'ajax/blog.php" like noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" title="Like">
					<h3><i class="fas fa-thumbs-up"></i></h3>
					<p>'.$contagem['comentario_like'].'</p>
				</button>
				<button deslike noticiaDeslike="'.$noticia.'" craveDeslike="'.$_SESSION['id'].'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" title="Deslike">
					<h3><i class="fas fa-thumbs-down"></i></h3>
					<p>'.$contagem['comentario_deslike'].'</p>
				</button>	
		';
	}

	/******************************************************/
	// Respostas

	//contar likes e inserir, ou atualizar, ação dada pelo usuário
	if(isset($_POST['idLikeResposta']) && $_POST['idLikeResposta'] == 'likeResposta'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaLike'];
		$comentario = $_POST['comentarioLike'];
		$resposta = $_POST['respostaLike'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
		$contagem->execute(array($resposta));
		$contagem = $contagem->fetch();

		$numero = $contagem['comentario_like'];
		$numero = $numero+1;

		/****************************************/
		// inserindo na tabela de feedback

		$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_respostas` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ? AND resposta_id = ?");
		$informacaoFeedback->execute(array($usuario,$noticia,$comentario,$resposta));

		if($informacaoFeedback->rowCount() == 1){
			$informacaoFeedback = $informacaoFeedback->fetch();

			if($informacaoFeedback['comentario_deslike'] == 1){
				$feedback = MySql::conexaobd()->prepare("UPDATE `feedback_respostas` SET comentario_like = ?, comentario_deslike = ? WHERE id = ?");
				$feedback->execute(array(1,0,$informacaoFeedback['id']));

				$recontagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
				$recontagem->execute(array($resposta));
				$recontagem = $recontagem->fetch();

				$numeroLike = $recontagem['comentario_like'];
				$numeroLike = $numeroLike + 1;

				$numeroDeslike = $recontagem['comentario_deslike'];
				$numeroDeslike = $numeroDeslike - 1;

				$sql = MySql::conexaobd()->prepare("UPDATE `respostas` SET comentario_like = ?, comentario_deslike = ? WHERE id = ?");
				$sql->execute(array($numeroLike,$numeroDeslike,$resposta));

				/*************************************************/

				$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
				$contagem->execute(array($resposta));
				$contagem = $contagem->fetch();

				$data.='
						<button action="'.INCLUDE_PATH.'ajax/blog.php" no-likeResposta noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" respostaLike="'.$resposta.'" title="Like">
							<h3><i class="fas fa-thumbs-up"></i></h3>
							<p>'.$contagem['comentario_like'].'</p>
						</button>
						<button deslikeResposta noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" respostaDeslike="'.$resposta.'" title="Deslike">
							<h3><i class="fas fa-thumbs-down"></i></h3>
							<p>'.$contagem['comentario_deslike'].'</p>
						</button>	
				';
			}
		}else{
			$feedback = MySql::conexaobd()->prepare("INSERT INTO `feedback_respostas` VALUES (null,?,?,?,?,?,?)");
			$feedback->execute(array($usuario,$noticia,$comentario,$resposta,1,0));

			$sql = MySql::conexaobd()->prepare("UPDATE `respostas` SET comentario_like = ? WHERE id = ?");
			$sql->execute(array($numero,$resposta));

			/*************************************************/

			$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
			$contagem->execute(array($resposta));
			$contagem = $contagem->fetch();

			$data.='
					<button action="'.INCLUDE_PATH.'ajax/blog.php" no-likeResposta noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" respostaLike="'.$resposta.'" title="Like">
						<h3><i class="fas fa-thumbs-up"></i></h3>
						<p>'.$contagem['comentario_like'].'</p>
					</button>
					<button deslikeResposta noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" respostaDeslike="'.$resposta.'" title="Deslike">
						<h3><i class="fas fa-thumbs-down"></i></h3>
						<p>'.$contagem['comentario_deslike'].'</p>
					</button>	
			';
		}
	}

	//tirar like
	if(isset($_POST['idNoLikeResposta']) && $_POST['idNoLikeResposta'] == 'no-likeResposta'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaLike'];
		$comentario = $_POST['comentarioLike'];
		$resposta = $_POST['respostaLike'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
		$contagem->execute(array($resposta));
		$contagem = $contagem->fetch();

		$numero = $contagem['comentario_like'];
		$numero = $numero - 1;

		/****************************************/
		// deletar da tabela de feedback

		$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_respostas` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ? AND resposta_id = ?");
		$informacaoFeedback->execute(array($usuario,$noticia,$comentario,$resposta));
		$informacaoFeedback = $informacaoFeedback->fetch();

		$feedback = MySql::conexaobd()->prepare("DELETE FROM `feedback_respostas` WHERE id = ?");
		$feedback->execute(array($informacaoFeedback['id']));

		$sql = MySql::conexaobd()->prepare("UPDATE `respostas` SET comentario_like = ? WHERE id = ?");
		$sql->execute(array($numero,$resposta));

		/*************************************************/

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
		$contagem->execute(array($resposta));
		$contagem = $contagem->fetch();

		$data.='
				<button action="'.INCLUDE_PATH.'ajax/blog.php" likeResposta noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" respostaLike="'.$resposta.'" title="Like">
					<h3><i class="fas fa-thumbs-up"></i></h3>
					<p>'.$contagem['comentario_like'].'</p>
				</button>
				<button deslikeResposta noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" respostaDeslike="'.$resposta.'" title="Deslike">
					<h3><i class="fas fa-thumbs-down"></i></h3>
					<p>'.$contagem['comentario_deslike'].'</p>
				</button>	
		';
	}

	//contar deslikes e inserir, ou atualizar, ação dada pelo usuário
	if(isset($_POST['idDeslikeResposta']) && $_POST['idDeslikeResposta'] == 'deslikeResposta'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaDeslike'];
		$comentario = $_POST['comentarioDeslike'];
		$resposta = $_POST['respostaDeslike'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
		$contagem->execute(array($resposta));
		$contagem = $contagem->fetch();

		$numero = $contagem['comentario_deslike'];
		$numero = $numero+1;

		/****************************************/
		// inserindo na tabela de feedback

		$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_respostas` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ? AND resposta_id = ?");
		$informacaoFeedback->execute(array($usuario,$noticia,$comentario,$resposta));

		if($informacaoFeedback->rowCount() == 1){
			$informacaoFeedback = $informacaoFeedback->fetch();

			if($informacaoFeedback['comentario_like'] == 1){
				$feedback = MySql::conexaobd()->prepare("UPDATE `feedback_respostas` SET comentario_like = ?, comentario_deslike = ? WHERE id = ?");
				$feedback->execute(array(0,1,$informacaoFeedback['id']));

				$recontagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
				$recontagem->execute(array($resposta));
				$recontagem = $recontagem->fetch();

				$numeroLike = $recontagem['comentario_like'];
				$numeroLike = $numeroLike - 1;

				$numeroDeslike = $recontagem['comentario_deslike'];
				$numeroDeslike = $numeroDeslike + 1;

				$sql = MySql::conexaobd()->prepare("UPDATE `respostas` SET comentario_like = ?, comentario_deslike = ? WHERE id = ?");
				$sql->execute(array($numeroLike,$numeroDeslike,$resposta));

				/*************************************/

				$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
				$contagem->execute(array($resposta));
				$contagem = $contagem->fetch();

				$data.='
						<button action="'.INCLUDE_PATH.'ajax/blog.php" likeResposta noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" respostaLike="'.$resposta.'" title="Like">
							<h3><i class="fas fa-thumbs-up"></i></h3>
							<p>'.$contagem['comentario_like'].'</p>
						</button>
						<button no-deslikeResposta noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" respostaDeslike="'.$resposta.'" title="Deslike">
							<h3><i class="fas fa-thumbs-down"></i></h3>
							<p>'.$contagem['comentario_deslike'].'</p>
						</button>
				';
			}
		}else{
			$feedback = MySql::conexaobd()->prepare("INSERT INTO `feedback_respostas` VALUES (null,?,?,?,?,?,?)");
			$feedback->execute(array($usuario,$noticia,$comentario,$resposta,0,1));

			$sql = MySql::conexaobd()->prepare("UPDATE `respostas` SET comentario_deslike = ? WHERE id = ?");
			$sql->execute(array($numero,$resposta));

			/*************************************/

			$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
			$contagem->execute(array($resposta));
			$contagem = $contagem->fetch();

			$data.='
					<button action="'.INCLUDE_PATH.'ajax/blog.php" likeResposta noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" respostaLike="'.$resposta.'" title="Like">
						<h3><i class="fas fa-thumbs-up"></i></h3>
						<p>'.$contagem['comentario_like'].'</p>
					</button>
					<button no-deslikeResposta noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" respostaDeslike="'.$resposta.'" title="Deslike">
						<h3><i class="fas fa-thumbs-down"></i></h3>
						<p>'.$contagem['comentario_deslike'].'</p>
					</button>
			';
		}
	}

	//tirar deslikes
	if(isset($_POST['idNoDeslikeResposta']) && $_POST['idNoDeslikeResposta'] == 'no-deslikeResposta'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaDeslike'];
		$comentario = $_POST['comentarioDeslike'];
		$resposta = $_POST['respostaDeslike'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
		$contagem->execute(array($resposta));
		$contagem = $contagem->fetch();

		$numero = $contagem['comentario_deslike'];
		$numero = $numero - 1;

		/****************************************/
		// deletar da tabela de feedback

		$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_respostas` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ? AND resposta_id = ?");
		$informacaoFeedback->execute(array($usuario,$noticia,$comentario,$resposta));
		$informacaoFeedback = $informacaoFeedback->fetch();

		$feedback = MySql::conexaobd()->prepare("DELETE FROM `feedback_respostas` WHERE id = ?");
		$feedback->execute(array($informacaoFeedback['id']));

		$sql = MySql::conexaobd()->prepare("UPDATE `respostas` SET comentario_deslike = ? WHERE id = ?");
		$sql->execute(array($numero,$resposta));

		/*************************************************/

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ?");
		$contagem->execute(array($resposta));
		$contagem = $contagem->fetch();

		$data.='
				<button action="'.INCLUDE_PATH.'ajax/blog.php" likeResposta noticiaLike="'.$noticia.'" comentarioLike="'.$comentario.'" respostaLike="'.$resposta.'" title="Like">
					<h3><i class="fas fa-thumbs-up"></i></h3>
					<p>'.$contagem['comentario_like'].'</p>
				</button>
				<button deslikeResposta noticiaDeslike="'.$noticia.'" action="'.INCLUDE_PATH.'ajax/blog.php" comentarioDeslike="'.$comentario.'" respostaDeslike="'.$resposta.'" title="Deslike">
					<h3><i class="fas fa-thumbs-down"></i></h3>
					<p>'.$contagem['comentario_deslike'].'</p>
				</button>	
		';
	}

	/**********************************************************/
	// denuncias

	if(isset($_POST['idDenuncia']) && $_POST['idDenuncia'] == 'denuncia'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaDenuncia'];
		$comentario = $_POST['comentarioDenuncia'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
		$contagem->execute(array($comentario));
		$contagem = $contagem->fetch();

		$numero = $contagem['denuncia'];
		$numero = $numero+1;

		$sql = MySql::conexaobd()->prepare("UPDATE `comentarios` SET denuncia = ? WHERE id = ?");
		$sql->execute(array($numero,$comentario));
	}

	if(isset($_POST['idDenunciaResposta']) && $_POST['idDenunciaResposta'] == 'denunciaResposta'){
		$usuario = $_SESSION['id'];
		$noticia = $_POST['noticiaDenuncia'];
		$comentario = $_POST['comentarioDenuncia'];
		$resposta = $_POST['respostaDenuncia'];

		$contagem = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE id = ? AND comentario_id = ? AND noticia_id = ?");
		$contagem->execute(array($resposta,$comentario,$noticia));
		$contagem = $contagem->fetch();

		$numero = $contagem['denuncia'];
		$numero = $numero+1;

		$sql = MySql::conexaobd()->prepare("UPDATE `respostas` SET denuncia = ? WHERE id = ?");
		$sql->execute(array($numero,$resposta));
	}

	echo $data;
?>