<?php
	$id = (int)$_SESSION['id'];

	$informacao = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE id = ?");
	$informacao->execute(array($id));
	$informacao = $informacao->fetch();

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];
		// $sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET tipo_usuario = ? WHERE id = ?");
		// $sql->execute(array(1,$informacao['id']));
		Metodos::apagarimagemusuario($informacao['foto_usuario']);
		$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET foto_usuario = ? WHERE id = ?");
		$sql->execute(array(0,$informacao['id']));
		$_SESSION['foto_usuario'] = '0';
?>
	<script type="text/javascript">
		setTimeout(function(){
			$('.fundo-transparente').fadeIn('fast');
			$('body').css('overflow','hidden');
			$('html,body').scrollTop(0);
			$('.janela-excluir-imagem').fadeOut('fast');
			$('.janela-sucesso-imagem').fadeIn('fast');
		},1000);
	</script>
<?php
	}
?>

<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-user-edit"></i></h3>
			<h2>Editar informações</h2>
		</div>
		<div class="painel-info">
			<form method="post" enctype="multipart/form-data">
				<?php
					if(isset($_POST['acao'])){
						$email = $_POST['email'];
						$senha = $_POST['senha'];

						$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE id != ?");
						$sql->execute(array($informacao['id']));
						$sql = $sql->fetch();

						if($email == '' || filter_var($email,FILTER_VALIDATE_EMAIL) == false || $email == $sql['email']){
							Metodos::mensagem('erro','E-mail inválido/existente!');
						}else{
							if($senha != ''){
								if(!preg_match('/^(?=.*\d)(?=.*[A-Z])[0-9A-Za-z-_.!@#%?]{8,}$/',$senha)){
									Metodos::mensagem('erro','Senha inválida!');
								}else{
									if($_FILES['foto']['name'] == ''){
										$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET email = ?, senha = ? WHERE id = ?");
										$sql->execute(array($email,md5($senha),$informacao['id']));
										Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-dados?sucesso');
									}else{
										if(Metodos::validacaoimagem($_FILES['foto']) == false){
											Metodos::mensagem('erro','Imagem inválida!');
										}else{
											Metodos::apagarimagemusuario($informacao['foto_usuario']);
											$foto = Metodos::uparimagemusuario($_FILES['foto']);

											$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET email = ?, senha = ?, foto_usuario = ? WHERE id = ?");
											$sql->execute(array($email,md5($senha),$foto,$informacao['id']));

											// renova sessão
											$_SESSION['email'] = $email;
											$_SESSION['foto_usuario'] = $foto;

											Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-dados?sucesso');
										}
									}
								}
							}else{
								if($_FILES['foto']['name'] == ''){
									$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET email = ? WHERE id = ?");
									Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-dados?sucesso');
								}else{
									if(Metodos::validacaoimagem($_FILES['foto']) == false){
										Metodos::mensagem('erro','Imagem inválida!');
									}else{
										Metodos::apagarimagemusuario($informacao['foto_usuario']);
										$foto = Metodos::uparimagemusuario($_FILES['foto']);

										$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET email = ?, foto_usuario = ? WHERE id = ?");
										$sql->execute(array($email,$foto,$informacao['id']));
										$_SESSION['foto_usuario'] = $foto;
										Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-dados?sucesso');
									}
								}
							}
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Usuário atualizado com sucesso!');
					}
				?>
				<div>
					<p>E-mail</p>
					<input type="email" name="email" value="<?php echo $informacao['email']; ?>">
				</div>
				<div class="senha-usuario">
					<div class="tooltip">
						<p>Senha</p>
						<h3><i class="fas fa-question-circle"></i></h3>

						<div>
							<div>
								<p>A senha deve conter, pelo menos, 1 letra maiúscula e 1 número</p>
							</div>
						</div>
					</div><!-- tooltip -->

					<input type="password" name="senha">
					<div class="mostrar-senha">
						<h3><i class="fas fa-eye"></i></h3>
					</div>
				</div><!-- senha-usuario -->
				<?php
					if($informacao['foto_usuario'] == '0' || $informacao['foto_usuario'] == 0 || $informacao['foto_usuario'] == 'Array' || $informacao['foto_usuario'] == ''){
				?>
				<div style="padding: 0;"></div>
				<div>
					<p>Colocar foto de perfil</p>
					<label id="label-foto" for="foto">Selecionar arquivo</label>
					<input id="foto" type="file" name="foto">
				</div>
				<?php
					}else{
				?>
				<div class="foto-perfil-atual">
					<p>Foto de perfil atual</p>
					<div>
						<div style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/usuarios/<?php echo $informacao['foto_usuario']; ?>');"></div>
						<h3 exclusaoimagem title="Excluir foto"><i class="fas fa-trash-alt"></i></h3>
					</div>
				</div>
				<div>
					<p>Alterar foto de perfil</p>
					<label id="label-foto" for="foto">Selecionar arquivo</label>
					<input id="foto" type="file" name="foto">
				</div>
				<?php
					}
				?>
				<div>
					<input type="submit" name="acao" value="Atualizar">
				</div>
			</form>
		</div>
	</div>

	<div class="janela-excluir-imagem">
		<div class="excluir-imagem">
			<div>
				<h3><i class="fas fa-exclamation-triangle"></i></h3>
				<p>Deseja excluir essa imagem?</p>
				<p>A imagem não poderá ser recuperada depois</p>
				<a title="Excluir foto" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-dados?excluir=<?php echo $informacao['id']; ?>">
					<h3><i class="fas fa-trash-alt"></i></h3>
					<p>Excluir foto</p>
				</a>
				<div class="fechar-janela">
					<img title="Fechar" src="<?php echo INCLUDE_PATH; ?>imagens/x.png">
				</div>
			</div>
		</div>
	</div>

	<div class="janela-sucesso-imagem">
		<div class="sucesso-janela">
			<h3><i class="fas fa-check-circle"></i></h3>
			<p>Imagem excluída com sucesso!</p>
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-dados">Retornar ao painel</a>
		</div>
	</div>
</section>