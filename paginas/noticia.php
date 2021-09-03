<?php
	$urlnoticia = explode('/',$_GET['url']);

	$verificarcategoria = MySql::conexaobd()->prepare("SELECT * FROM `categorias_noticia` WHERE url = ?");
	$verificarcategoria->execute(array($urlnoticia[1]));

	if($verificarcategoria->rowCount() == 0){
		Metodos::redirecionamentoespecifico(INCLUDE_PATH);
	}

	/**************************************************************/

	$informarcategoria = $verificarcategoria->fetch();

	$noticia = MySql::conexaobd()->prepare("SELECT * FROM `noticias` WHERE url = ? AND categoria_id = ?");
	$noticia->execute(array($urlnoticia[2],$informarcategoria['id']));

	if($noticia->rowCount() == 0){
		Metodos::redirecionamentoespecifico(INCLUDE_PATH);
	}

	$noticia = $noticia->fetch();

	/************************************************/
	// atualizar visualizações

	$contagemView = $noticia['views'] + 1;

	$updateView = MySql::conexaobd()->prepare("UPDATE `noticias` SET views = ? WHERE url = ? AND categoria_id = ?");
	$updateView->execute(array($contagemView,$urlnoticia[2],$informarcategoria['id']));
?>
<section>
	<div class="noticia-blog">
		<div class="title-noticia">
			<h1><?php echo ucfirst($noticia['titulo']); ?></h1>
		</div><!-- title-noticia -->

		<div class="informacoes-noticia">
			<?php
				$imagens = MySql::conexaobd()->prepare("SELECT * FROM `imagens_noticias` WHERE noticia_id = ?");
				$imagens->execute(array($noticia['id']));
				$imagens = $imagens->fetchAll();

				foreach ($imagens as $key => $value){
			?>
			<img src="<?php echo INCLUDE_PATH_PAINEL; ?>imagens/noticias/<?php echo $value['foto_noticia']; ?>">
			<?php
				}
			?>
			<p><?php echo ucfirst($noticia['conteudo']); ?></p>
		</div><!-- informacoes-noticia -->
	</div><!-- noticia-blog -->

	<div class="sessao-comentarios">
		<?php
			if(!isset($_SESSION['login'])){
		?>
		<div class="comentarios-box">
			<h1 class="abrir-janela">Entre na sua conta para comentar nesta notícia!</h1>
		</div><!-- comentarios-box -->
		<?php
			}else{
		?>
		<div class="pergunta">
			<form class="post-comentario" action="<?php echo INCLUDE_PATH; ?>ajax/publicacoes.php" method="post">
				<div>
					<p>Faça um comentário</p>
					<textarea name="comentario"></textarea>
				</div>
				<div>
					<input type="hidden" name="noticia" value="<?php echo $noticia['id']; ?>">
					<input type="hidden" name="acao-comentario">
					<input type="submit" value="Enviar">
				</div>
			</form>
		</div><!-- pergunta -->

		<div class="title-sessao-comentarios">
			<h2>Comentários</h2>
		</div><!-- title-sessao-comentarios -->
		<?php
				$comentarios = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE noticia_id = ?");
				$comentarios->execute(array($noticia['id']));

				if($comentarios->rowCount() == 0){
		?>
		<div class="comentarios-box">
			<h2>Não existem comentários ainda nessa notícia!</h2>
		</div><!-- comentarios-box -->
		<?php
				}else{
		?>
		<div class="comentarios">
			<?php
				$comentarios = $comentarios->fetchAll();

				foreach ($comentarios as $key => $value){
					$usuario = Informacoes::pegarIDusuario($value['usuario_id']);
			?>
				<div>
					<div class="user-coment">
						<div class="info-user-coment">
							<?php
								if($usuario['foto_usuario'] != '0' || $usuario['foto_usuario'] != 0 || $usuario['foto_usuario'] != 'Array' || $usuario['foto_usuario'] != ''){
							?>
							<div class="foto-user-coment" style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/usuarios/<?php echo $usuario['foto_usuario']; ?>');"></div>
							<?php
								}else{
							?>
							<div class="anonymous-foto-user">
								<h3><i class="fas fa-user"></i></h3>
							</div><!-- anonymous-foto-user -->
							<?php
								}
							?>

							<div class="coment-info">
								<h4><?php echo ucfirst($usuario['nome']); ?> <?php echo ucfirst($usuario['sobrenome']); ?></h4>
							</div><!-- coment-info -->

							<?php
								if(strlen($value['comentario']) >= 60){
							?>
							<div class="coment">
								<p><?php echo ucfirst($value['comentario']); ?></p>
							</div><!-- coment -->
							<?php
								}else{
							?>
							<div class="short-coment">
								<p><?php echo ucfirst($value['comentario']); ?></p>
							</div><!-- short-coment -->
							<?php
								}
							?>	
							<div class="clear"></div>
						</div><!-- info-user-coment -->

						<div class="action-user">
							<?php
								$informacaoFeedback = MySql::conexaobd()->prepare("SELECT * FROM `feedback_comentarios` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ?");
								$informacaoFeedback->execute(array($_SESSION['id'],$noticia['id'],$value['id']));

								if($informacaoFeedback->rowCount() == 1){
									$informacaoFeedback = $informacaoFeedback->fetch();

									if($informacaoFeedback['comentario_like'] == 1){
							?>
							<div class="feedbacks">
								<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" no-like noticiaLike="<?php echo $noticia['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
									<h3><i class="fas fa-thumbs-up"></i></h3>
									<p><?php echo $value['comentario_like']; ?></p>
								</button>
								<button deslike noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" comentarioDeslike="<?php echo $value['id']; ?>" title="Deslike">
									<h3><i class="fas fa-thumbs-down"></i></h3>
									<p><?php echo $value['comentario_deslike']; ?></p>
								</button>
							</div><!-- feedbacks -->
							<?php
									}else{
							?>
							<div class="feedbacks">
								<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" like noticiaLike="<?php echo $noticia['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
									<h3><i class="fas fa-thumbs-up"></i></h3>
									<p><?php echo $value['comentario_like']; ?></p>
								</button>
								<button no-deslike noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" comentarioDeslike="<?php echo $value['id']; ?>" title="Deslike">
									<h3><i class="fas fa-thumbs-down"></i></h3>
									<p><?php echo $value['comentario_deslike']; ?></p>
								</button>
							</div><!-- feedbacks -->
							<?php
									}
								}else{
							?>
							<div class="feedbacks">
								<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" like noticiaLike="<?php echo $noticia['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
									<h3><i class="fas fa-thumbs-up"></i></h3>
									<p><?php echo $value['comentario_like']; ?></p>
								</button>
								<button deslike noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" comentarioDeslike="<?php echo $value['id']; ?>" title="Deslike">
									<h3><i class="fas fa-thumbs-down"></i></h3>
									<p><?php echo $value['comentario_deslike']; ?></p>
								</button>
							</div><!-- feedbacks -->
							<?php
								}///fim do rowcount
							?>
								<span title="Responder">
									<h3><i class="fas fa-reply"></i></h3>
									<p>Responder</p>
								</span>
								<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" denunciar noticiaDenuncia="<?php echo $noticia['id']; ?>" comentarioDenuncia="<?php echo $value['id']; ?>" title="Denunciar">
									<h3><i class="fas fa-flag"></i></h3>
									<p>Denunciar</p>
								</button>
						</div><!-- action-user -->

						<div class="answer-coment">
							<form class="post-resposta" action="<?php echo INCLUDE_PATH; ?>ajax/publicacoes.php" method="post">
								<div>
									<textarea name="resposta"></textarea>
								</div>
								<div>
									<input type="hidden" name="noticia-resposta" value="<?php echo $noticia['id']; ?>">
									<input type="hidden" name="comentario-resposta" value="<?php echo $value['id']; ?>">
									<input type="hidden" name="acao-resposta">
									<input type="submit" value="Enviar">
								</div>
							</form>
						</div><!-- answer-coment -->
					</div><!-- user-coment -->

					<?php
						$respostasComentario = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE comentario_id = ? AND noticia_id = ? AND resposta_id = ?");
						$respostasComentario->execute(array($value['id'],$noticia['id'],0));

						if($respostasComentario->rowCount() >= 1){
					?>
					<div class="title-sessao-comentarios">
						<h2>Respostas</h2>
						<h3 title="Ver respostas"><i class="fas fa-plus-circle"></i></h3>
					</div><!-- title-sessao-comentarios -->

					<div class="respostas">
					<?php
						$respostasComentario = $respostasComentario->fetchAll();

							foreach ($respostasComentario as $key2 => $value2){
								$usuarioResposta = Informacoes::pegarIDusuario($value2['usuario_id']);
					?>
					<div>
						<div class="resposta-content">
							<div class="info-user-coment">
								<?php
									if($usuarioResposta['foto_usuario'] == '0' || $usuarioResposta['foto_usuario'] == 0 || $usuarioResposta['foto_usuario'] == 'Array' || $usuarioResposta['foto_usuario'] == ''){
								?>
								<div class="anonymous-foto-user">
									<h3><i class="fas fa-user"></i></h3>
								</div><!-- anonymous-foto-user -->
								<?php
									}else{
								?>
								<div class="foto-user-coment" style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/usuarios/<?php echo $usuarioResposta['foto_usuario']; ?>');"></div>
								<?php
									}
								?>

								<div class="coment-info">
									<h4><?php echo ucfirst($usuarioResposta['nome']); ?> <?php echo ucfirst($usuarioResposta['sobrenome']); ?></h4>
								</div><!-- coment-info -->

								<?php
									if(strlen($value2['resposta']) >= 60){
								?>
								<div class="coment">
									<p><?php echo ucfirst($value2['resposta']); ?></p>
								</div><!-- coment -->
								<?php
									}else{
								?>
								<div class="short-coment">
									<p><?php echo ucfirst($value2['resposta']); ?></p>
								</div><!-- short-coment -->
								<?php
									}
								?>		
								<div class="clear"></div>
							</div><!-- info-user-coment -->

							<div class="action-user">
								<?php
									$informacaoFeedbackResposta = MySql::conexaobd()->prepare("SELECT * FROM `feedback_respostas` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ? AND resposta_id = ?");
									$informacaoFeedbackResposta->execute(array($_SESSION['id'],$noticia['id'],$value['id'],$value2['id']));

									if($informacaoFeedbackResposta->rowCount() == 1){
											$informacaoFeedbackResposta = $informacaoFeedbackResposta->fetch();

										if($informacaoFeedbackResposta['comentario_like'] == 1){
								?>
								<div class="feedbacks">
									<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" no-likeResposta noticiaLike="<?php echo $noticia['id']; ?>" respostaLike="<?php echo $value2['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
										<h3><i class="fas fa-thumbs-up"></i></h3>
										<p><?php echo $value2['comentario_like']; ?></p>
									</button>
									<button deslikeResposta noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" comentarioDeslike="<?php echo $value['id']; ?>" respostaDeslike="<?php echo $value2['id']; ?>" title="Deslike">
										<h3><i class="fas fa-thumbs-down"></i></h3>
										<p><?php echo $value2['comentario_deslike']; ?></p>
									</button>
								</div><!-- feedbacks -->
								<?php
										}else{
								?>
								<div class="feedbacks">
									<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" likeResposta noticiaLike="<?php echo $noticia['id']; ?>" respostaLike="<?php echo $value2['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
										<h3><i class="fas fa-thumbs-up"></i></h3>
										<p><?php echo $value2['comentario_like']; ?></p>
									</button>
									<button no-deslikeResposta noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" comentarioDeslike="<?php echo $value['id']; ?>" respostaDeslike="<?php echo $value2['id']; ?>" title="Deslike">
										<h3><i class="fas fa-thumbs-down"></i></h3>
										<p><?php echo $value2['comentario_deslike']; ?></p>
									</button>
								</div><!-- feedbacks -->
								<?php
										}
									}else{
								?>
								<div class="feedbacks">
									<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" likeResposta respostaLike="<?php echo $value2['id']; ?>" noticiaLike="<?php echo $noticia['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
										<h3><i class="fas fa-thumbs-up"></i></h3>
										<p><?php echo $value2['comentario_like']; ?></p>
									</button>
									<button deslikeResposta noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" respostaDeslike="<?php echo $value2['id']; ?>" comentarioDeslike="<?php echo $value['id']; ?>" title="Deslike">
										<h3><i class="fas fa-thumbs-down"></i></h3>
										<p><?php echo $value2['comentario_deslike']; ?></p>
									</button>
								</div><!-- feedbacks -->
								<?php
									}
								?>
								<span title="Responder">
									<h3><i class="fas fa-reply"></i></h3>
									<p>Responder</p>
								</span>
								<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" denunciarResposta noticiaDenuncia="<?php echo $noticia['id']; ?>" respostaDenuncia="<?php echo $value2['id']; ?>" comentarioDenuncia="<?php echo $value['id']; ?>" title="Denunciar">
									<h3><i class="fas fa-flag"></i></h3>
									<p>Denunciar</p>
								</button>
							</div><!-- action-user -->

							<div class="answer-coment">
								<form class="post-responder-resposta" action="<?php echo INCLUDE_PATH; ?>ajax/publicacoes.php" method="post">
									<div>
										<textarea name="resposta-resposta"></textarea>
									</div>
									<div>
										<input type="hidden" name="noticia-resposta-resposta" value="<?php echo $noticia['id']; ?>">
										<input type="hidden" name="comentario-resposta-resposta" value="<?php echo $value['id']; ?>">
										<input type="hidden" name="value" value="<?php echo $value2['id']; ?>">
										<input type="hidden" name="acao-resposta-resposta">
										<input type="submit" value="Enviar">
									</div>
								</form>
							</div><!-- answer-coment -->

							<?php
								$respostasResposta = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE noticia_id = ? AND comentario_id = ? AND resposta_id = ?");
								$respostasResposta->execute(array($noticia['id'],$value['id'],$value2['id']));

								if($respostasResposta->rowCount() == 0){
							?>
							<div></div>
							<?php
								}else{
									$respostasResposta = $respostasResposta->fetchAll();

									foreach ($respostasResposta as $key3 => $value3){
										$usuarioResposta = Informacoes::pegarIDusuario($value3['usuario_id']);
							?>
								<div class="border-class"></div>

								<div class="resposta-content2">
									<div class="info-user-coment">
										<?php
											if($usuarioResposta['foto_usuario'] == '0' || $usuarioResposta['foto_usuario'] == 0 || $usuarioResposta['foto_usuario'] == 'Array' || $usuarioResposta['foto_usuario'] == ''){
										?>
										<div class="anonymous-foto-user">
											<h3><i class="fas fa-user"></i></h3>
										</div><!-- anonymous-foto-user -->
										<?php
											}else{
										?>
										<div class="foto-user-coment" style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/usuarios/<?php echo $usuarioResposta['foto_usuario']; ?>');"></div>
										<?php
											}
										?>

										<div class="coment-info">
											<h4><?php echo ucfirst($usuarioResposta['nome']); ?> <?php echo ucfirst($usuarioResposta['sobrenome']); ?></h4>
										</div><!-- coment-info -->

										<?php
											if(strlen($value3['resposta']) >= 60){
										?>
										<div class="coment">
											<p><?php echo ucfirst($value3['resposta']); ?></p>
										</div><!-- coment -->
										<?php
											}else{
										?>
										<div class="short-coment">
											<p><?php echo ucfirst($value3['resposta']); ?></p>
										</div><!-- short-coment -->
										<?php
											}
										?>			
										<div class="clear"></div>
									</div><!-- info-user-coment -->

									<div class="action-user">
										<?php
											$informacaoFeedbackResposta = MySql::conexaobd()->prepare("SELECT * FROM `feedback_respostas` WHERE usuario_id = ? AND noticia_id = ? AND comentario_id = ? AND resposta_id = ?");
											$informacaoFeedbackResposta->execute(array($_SESSION['id'],$noticia['id'],$value['id'],$value3['id']));

											if($informacaoFeedbackResposta->rowCount() == 1){
													$informacaoFeedbackResposta = $informacaoFeedbackResposta->fetch();

												if($informacaoFeedbackResposta['comentario_like'] == 1){
										?>
										<div class="feedbacks">
											<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" no-likeResposta noticiaLike="<?php echo $noticia['id']; ?>" respostaLike="<?php echo $value3['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
												<h3><i class="fas fa-thumbs-up"></i></h3>
												<p><?php echo $value3['comentario_like']; ?></p>
											</button>
											<button deslikeResposta noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" comentarioDeslike="<?php echo $value['id']; ?>" respostaDeslike="<?php echo $value3['id']; ?>" title="Deslike">
												<h3><i class="fas fa-thumbs-down"></i></h3>
												<p><?php echo $value3['comentario_deslike']; ?></p>
											</button>
										</div><!-- feedbacks -->
										<?php
												}else{
										?>
										<div class="feedbacks">
											<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" likeResposta noticiaLike="<?php echo $noticia['id']; ?>" respostaLike="<?php echo $value3['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
												<h3><i class="fas fa-thumbs-up"></i></h3>
												<p><?php echo $value3['comentario_like']; ?></p>
											</button>
											<button no-deslikeResposta noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" comentarioDeslike="<?php echo $value['id']; ?>" respostaDeslike="<?php echo $value3['id']; ?>" title="Deslike">
												<h3><i class="fas fa-thumbs-down"></i></h3>
												<p><?php echo $value3['comentario_deslike']; ?></p>
											</button>
										</div><!-- feedbacks -->
										<?php
												}
											}else{
										?>
										<div class="feedbacks">
											<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" likeResposta respostaLike="<?php echo $value3['id']; ?>" noticiaLike="<?php echo $noticia['id']; ?>" comentarioLike="<?php echo $value['id']; ?>" title="Like">
												<h3><i class="fas fa-thumbs-up"></i></h3>
												<p><?php echo $value3['comentario_like']; ?></p>
											</button>
											<button deslikeResposta noticiaDeslike="<?php echo $noticia['id']; ?>" action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" respostaDeslike="<?php echo $value3['id']; ?>" comentarioDeslike="<?php echo $value['id']; ?>" title="Deslike">
												<h3><i class="fas fa-thumbs-down"></i></h3>
												<p><?php echo $value3['comentario_deslike']; ?></p>
											</button>
										</div><!-- feedbacks -->
										<?php
											}
										?>
										<span title="Responder">
											<h3><i class="fas fa-reply"></i></h3>
											<p>Responder</p>
										</span>
										<button action="<?php echo INCLUDE_PATH; ?>ajax/blog.php" denunciarResposta noticiaDenuncia="<?php echo $noticia['id']; ?>" respostaDenuncia="<?php echo $value3['id']; ?>" comentarioDenuncia="<?php echo $value['id']; ?>" title="Denunciar">
											<h3><i class="fas fa-flag"></i></h3>
											<p>Denunciar</p>
										</button>
									</div><!-- action-user -->

									<div class="answer-coment">
										<form class="post-responder-resposta" action="<?php echo INCLUDE_PATH; ?>ajax/publicacoes.php" method="post">
											<div>
												<textarea name="resposta-resposta"><b>@<?php echo ucfirst($usuarioResposta['nome']); ?></b> </textarea>
											</div>
											<div>
												<input type="hidden" name="noticia-resposta-resposta" value="<?php echo $noticia['id']; ?>">
												<input type="hidden" name="comentario-resposta-resposta" value="<?php echo $value['id']; ?>">
												<input type="hidden" name="value" value="<?php echo $value2['id']; ?>">
												<input type="hidden" name="acao-resposta-resposta">
												<input type="submit" value="Enviar">
											</div>
										</form>
									</div><!-- answer-coment -->
								</div><!-- resposta-content2 -->
							<?php
									}
								}//respostas da resposta
							?>
						</div><!-- resposta-content -->
						<div class="border-answer"></div>
					</div>
						<?php
								}
						?>
					</div><!-- respostas -->
						<?php
							}else{
						?>
					<div></div>
				<?php
					}//respostas para o comentário
				?>
				</div>
			<?php
				}
			?>
		</div><!-- comentarios -->
		<?php
				}
			}
		?>
	</div><!-- sessao-comentarios -->
</section>