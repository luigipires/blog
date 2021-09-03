<?php
	permissao(2);
	
	if(isset($_GET['editar'])){
		$id = (int)$_GET['editar'];

		$informacao = MySql::conexaobd()->prepare("SELECT * FROM `avaliacoes` WHERE id = ?");
		$informacao->execute(array($id));
		$informacao = $informacao->fetch();
	}else{
		Metodos::mensagem('alerta','Você precisa do ID!');
		die();
	}

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		$informacao = MySql::conexaobd()->prepare("SELECT * FROM `avaliacoes` WHERE id = ?");
		$informacao->execute(array($excluir));
		$informacao = $informacao->fetch();

		Metodos::apagarimagemavaliacao($informacao['foto_usuario']);
		$sql = MySql::conexaobd()->prepare("UPDATE `avaliacoes` SET foto_usuario = ? WHERE id = ?");
		$sql->execute(array(0,$id));
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
			<h3><i class="fas fa-edit"></i></h3>
			<h2>Editar avaliação</h2>
		</div>
		<div class="painel-info">
			<form method="post" enctype="multipart/form-data">
				<?php
					if(isset($_POST['acao'])){
						$nome = $_POST['nome'];
						$conteudo = $_POST['conteudo'];

						if($nome == ''){
							Metodos::mensagem('erro','Você precisa colocar o nome!');
						}else if($conteudo == ''){
							Metodos::mensagem('erro','Você precisa inserir o conteúdo!');
						}else{
							if($_FILES['foto']['name'] != ''){
								if(Metodos::validacaoimagem($_FILES['foto']) == false){
									Metodos::mensagem('erro','Foto inválida!');
								}else{
									Metodos::apagarimagemavaliacao($informacao['foto_usuario']);
									$foto = Metodos::uparimagemavaliacao($_FILES['foto']);

									$sql = MySql::conexaobd()->prepare("UPDATE `avaliacoes` SET nome_usuario = ?, conteudo = ?, foto_usuario = ? WHERE id = ?");
									$sql->execute(array($nome,$conteudo,$foto,$id));
									Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-avaliacoes?editar='.$id.'&sucesso');
								}
							}else{
								$sql = MySql::conexaobd()->prepare("UPDATE `avaliacoes` SET nome_usuario = ?, conteudo = ? WHERE id = ?");
								$sql->execute(array($nome,$conteudo,$id));
								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-avaliacoes?editar='.$id.'&sucesso');
							}
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Avaliação atualizada com sucesso!');
					}
				?>
				<div>
					<p>Nome do usuário</p>
					<input type="text" name="nome" value="<?php echo $informacao['nome_usuario']; ?>">
				</div>
				<div>
					<p>Avaliação do usuário</p>
					<textarea name="conteudo"><?php echo ucfirst($informacao['conteudo']); ?></textarea>
				</div>
				<?php
					if($informacao['foto_usuario'] == '0' || $informacao['foto_usuario'] == 0 || $informacao['foto_usuario'] == 'Array' || $informacao['foto_usuario'] == ''){
				?>
				<div style="padding: 0;"></div>
				<div>
					<p>Colocar foto do usuário</p>
					<label id="label-foto" for="foto">Selecionar arquivo</label>
					<input id="foto" type="file" name="foto">
				</div>
				<?php
					}else{
				?>
				<div class="foto-perfil-atual">
					<p>Foto de usuário</p>
					<div>
						<div style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/avaliacoes/<?php echo $informacao['foto_usuario']; ?>');"></div>
						<h3 exclusaoimagem title="Excluir foto"><i class="fas fa-trash-alt"></i></h3>
					</div>
				</div>
				<div>
					<p>Alterar foto do usuário</p>
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
				<a title="Excluir foto" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-avaliacoes?editar=<?php echo $id; ?>&excluir=<?php echo $informacao['id']; ?>">
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
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-avaliacoes?editar=<?php echo $id; ?>">Retornar ao painel</a>
		</div>
	</div>
</section>