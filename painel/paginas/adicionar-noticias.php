<?php
	permissao(1,2);
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-newspaper"></i></h3>
			<h2>Adicionar notícias</h2>
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
						}else if($_FILES['foto']['name'][0] == ''){
							Metodos::mensagem('erro','Você precisa escolher uma foto!');
						}else{
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
								$sql = MySql::conexaobd()->prepare("INSERT INTO `noticias` VALUES(null,?,?,?,?,?)");
								$sql->execute(array($categorianoticia,$titulo,$conteudo,$url,0));
								$id = MySql::conexaobd()->lastInsertId();

								foreach ($foto as $key => $value){
									$sql2 = MySql::conexaobd()->prepare("INSERT INTO `imagens_noticias` VALUES(null,?,?)");
									$sql2->execute(array($id,$value));
								}

								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'adicionar-noticias?sucesso');
							}
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Notícia cadastrada com sucesso!');
					}
				?>
				<div>
					<p>Título da notícia</p>
					<input type="text" name="titulo" value="<?php echo Metodos::recuperarcampopreenchido('titulo'); ?>">
				</div>
				<div>
					<p>Conteúdo da notícia</p>
					<textarea name="conteudo"><?php echo Metodos::recuperarcampopreenchido('conteudo'); ?></textarea>
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
						<option value="<?php echo $value['id']; ?>"><?php echo ucfirst($value['nome_categoria']); ?></option>
						<?php
							}
						?>
					</select>
				</div>
				<div>
					<p>Upload de fotos</p>
					<label id="label-foto" for="foto">Selecionar arquivos</label>
					<input id="foto" multiple type="file" name="foto[]">
				</div>
				<div>
					<input type="submit" name="acao" value="Adicionar">
				</div>
			</form>
		</div>
	</div>
</section>