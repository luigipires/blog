<?php
	permissao(2);
	
	if(isset($_GET['editar'])){
		$id = (int)$_GET['editar'];

		$informacao = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE id = ?");
		$informacao->execute(array($id));
		$informacao = $informacao->fetch();
	}else{
		Metodos::mensagem('alerta','Você precisa do ID!');
		die();
	}

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		Metodos::apagarimagemusuario($informacao['foto_usuario']);
		$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET foto_usuario = ? WHERE id = ?");
		$sql->execute(array(0,$informacao['id']));
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
			<h2>Editar usuário</h2>
		</div>
		<div class="painel-info">
			<form method="post" enctype="multipart/form-data">
				<?php
					if(isset($_POST['acao'])){
						$nome = $_POST['nome'];
						$sobrenome = $_POST['sobrenome'];
						$email = $_POST['email'];
						$tipousuario = $_POST['tipo_usuario'];

						$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE id != ?");
						$sql->execute(array($informacao['id']));
						$sql = $sql->fetch();

						if($nome == ''){
							Metodos::mensagem('erro','O nome precisa ser inserido!');
						}else if($sobrenome == ''){
							Metodos::mensagem('erro','O sobrenome precisa ser inserido!');
						}else if($email == '' || filter_var($email,FILTER_VALIDATE_EMAIL) == false || $email == $sql['email']){
							Metodos::mensagem('erro','E-mail inválido/existente!');
						}else{
							if($_FILES['foto']['name'] == ''){
								$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET nome = ?, sobrenome = ?, email = ?, tipo_usuario = ? WHERE id = ?");
								$sql->execute(array($nome,$sobrenome,$email,$tipousuario,$informacao['id']));
								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-usuarios?editar='.$informacao['id'].'&sucesso');
							}else{
								if(Metodos::validacaoimagem($_FILES['foto']) == false){
									Metodos::mensagem('erro','Imagem inválida!');
								}else{
									Metodos::apagarimagemusuario($informacao['foto_usuario']);
									$foto = Metodos::uparimagemusuario($_FILES['foto']);

									$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET nome = ?, sobrenome = ?, email = ?, foto_usuario = ?, tipo_usuario = ? WHERE id = ?");
									$sql->execute(array($nome,$sobrenome,$email,$foto,$tipousuario,$informacao['id']));

									Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-usuarios?editar='.$informacao['id'].'&sucesso');
								}
							}
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Usuário atualizado com sucesso!');
					}
				?>
				<div>
					<p>Nome</p>
					<input type="text" name="nome" value="<?php echo $informacao['nome']; ?>">
				</div>
				<div>
					<p>Sobrenome</p>
					<input type="text" name="sobrenome" value="<?php echo $informacao['sobrenome']; ?>">
				</div>
				<div>
					<p>E-mail</p>
					<input type="email" name="email" value="<?php echo $informacao['email']; ?>">
				</div>
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
						<h3 exclusaoimagem="excluir-foto" title="Excluir foto"><i class="fas fa-trash-alt"></i></h3>
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
					<p>Atribuir categoria do usuário</p>
					<select name="tipo_usuario">
						<?php
							foreach (Metodos::$tipousuario as $key => $value){
								if($key < $_SESSION['tipousuario']){
						?>
						<option <?php if($informacao['tipo_usuario'] == $key) echo 'selected';?> value="<?php echo $informacao['tipo_usuario']; ?>"><?php echo $value; ?></option>
						<?php
								}
							}
						?>
					</select>
				</div>
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
				<a title="Excluir foto" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-usuarios?editar=<?php echo $id; ?>&excluir=<?php echo $informacao['id']; ?>">
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
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-usuarios?editar=<?php echo $id; ?>">Retornar ao painel</a>
		</div>
	</div>
</section>