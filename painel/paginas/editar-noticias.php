<?php
	permissao(1,2);
	
	if(isset($_GET['editar'])){
		$id = (int)$_GET['editar'];

		$noticias = MySql::conexaobd()->prepare("SELECT * FROM `noticias` WHERE id = ?");
		$noticias->execute(array($id));
		$noticias = $noticias->fetch();

		if($noticias['id'] != $id){
			Metodos::redirecionamentoespecifico(INCLUDE_PATH_PAINEL.'lista-noticias');
		}

		$imagensnoticias = MySql::conexaobd()->prepare("SELECT * FROM `imagens_noticias` WHERE noticia_id = ?");
		$imagensnoticias->execute(array($noticias['id']));
		$imagensnoticias = $imagensnoticias->fetchAll();
	}else{
		Metodos::mensagem('alerta','Você precisa do ID!');
		die();
	}

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		$imagensnoticias2 = MySql::conexaobd()->prepare("SELECT * FROM `imagens_noticias` WHERE id = ?");
		$imagensnoticias2->execute(array($excluir));
		$imagensnoticias2 = $imagensnoticias2->fetch();

		Metodos::apagarimagemnoticia($imagensnoticias2['foto_noticia']);

		$sql = MySql::conexaobd()->prepare("DELETE FROM `imagens_noticias` WHERE id = ?");
		$sql->execute(array($excluir));
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
			<h3><i class="fas fa-file-image"></i></h3>
			<h2>Editar notícias</h2>
		</div>
		<div class="painel-info">
			<form method="post" enctype="multipart/form-data">
				<?php
					if(isset($_POST['acao'])){
						$titulo = $_POST['titulo'];
						$conteudo = $_POST['conteudo'];
						$categorianoticia = $_POST['categoria'];
						$foto = [];
						$fotosnoticia = '';
						$funcionamento = true;

						if($titulo == ''){
							Metodos::mensagem('erro','Você precisa colocar o título!');
						}else if($conteudo == ''){
							Metodos::mensagem('erro','Você precisa inserir o conteúdo!');
						}else if($_FILES['foto']['name'][0] != ''){
							$fotosnoticia = count($_FILES['foto']['name']);

							for($i = 0; $i < $fotosnoticia; $i++){
								$fotosupadas = ['type'=>$_FILES['foto']['type'][$i],'size'=>$_FILES['foto']['size'][$i]];

								if(Metodos::validacaoimagem($fotosupadas) == false){
									Metodos::mensagem('erro','Uma das fotos não é válida!');
									$funcionamento = false;
									break;
								}
							}

							if($funcionamento == true){
								for($i = 0; $i < $fotosnoticia; $i++){
									$fotosupadas = ['tmp_name'=>$_FILES['foto']['tmp_name'][$i],'name'=>$_FILES['foto']['name'][$i]];
									$foto[] = Metodos::uparimagemnoticia($fotosupadas);
								}

								$url = Metodos::gerarurl($titulo);
								$sql = MySql::conexaobd()->prepare("UPDATE `noticias` SET categoria_id = ?, titulo = ?,conteudo = ?, url = ? WHERE id = ?");
								$sql->execute(array($categorianoticia,$titulo,$conteudo,$url,$id));

								foreach ($foto as $key => $value){
									$sql2 = MySql::conexaobd()->prepare("INSERT INTO `imagens_noticias` VALUES(null,?,?)");
									$sql2->execute(array($id,$value));
								}

								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-noticias?editar='.$id.'&sucesso');
							}
						}else{
							$url = Metodos::gerarurl($titulo);
							$sql = MySql::conexaobd()->prepare("UPDATE `noticias` SET categoria_id = ?, titulo = ?,conteudo = ?, url = ? WHERE id = ?");
							$sql->execute(array($categorianoticia,$titulo,$conteudo,$url,$id));
							Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-noticias?editar='.$id.'&sucesso');
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Notícia atualizada com sucesso!');
					}
				?>
				<div>
					<p>Título da notícia</p>
					<input type="text" name="titulo" value="<?php echo $noticias['titulo']; ?>">
				</div>
				<div>
					<p>Conteúdo da notícia</p>
					<textarea name="conteudo"><?php echo $noticias['conteudo']; ?></textarea>
				</div>
				<div>
					<p>Categoria da notícia</p>
					<select name="categoria">
						<?php
							$categoria = MySql::conexaobd()->prepare("SELECT * FROM `categorias_noticia`");
							$categoria->execute();
							$categoria = $categoria->fetchAll();

							foreach ($categoria as $key => $value){
						?>
						<option <?php if($value['id'] == $noticias['categoria_id']) echo 'selected'; ?> value="<?php echo $value['id']; ?>"><?php echo ucfirst($value['nome_categoria']); ?></option>
						<?php
							}
						?>
					</select>
				</div>
				<div class="foto-imagens-atual">
					<p>Imagens da notícia</p>
					<div>
						<?php
							if(empty($imagensnoticias)){
						?>
						<div class="mensagem-foto">
							<p>Não há imagens cadastradas nesta notícia!</p>
						</div>
						<?php
							}else{
								foreach ($imagensnoticias as $key => $value){
						?>
							<div class="exposicao-fotos">
								<div>
									<div style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/noticias/<?php echo $value['foto_noticia']; ?>');"></div>
									<h3 idimagem="<?php echo $value['id']; ?>" exclusaoimagemmultiple title="Excluir foto"><i class="fas fa-trash-alt"></i></h3>
								</div>
							</div>
						<?php
								}
							}
						?>
					</div>
				</div>
				<div>
					<p>Adicionar imagens</p>
					<label id="label-foto" for="foto">Selecionar arquivos</label>
					<input multiple id="foto" type="file" name="foto[]">
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
				<a title="Excluir foto" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-noticias?editar=<?php echo $id; ?>&excluir=<?php echo $value['id']; ?>">
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
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-noticias?editar=<?php echo $id; ?>">Retornar ao painel</a>
		</div>
	</div>
</section>