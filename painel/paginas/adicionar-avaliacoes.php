<?php
	permissao(2);
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-pen-square"></i></h3>
			<h2>Adicionar avaliações</h2>
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
									$foto = Metodos::uparimagemavaliacao($_FILES['foto']);

									$sql = MySql::conexaobd()->prepare("INSERT INTO `avaliacoes` VALUES(null,?,?,?)");
									$sql->execute(array($nome,$conteudo,$foto));
									Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'adicionar-avaliacoes?sucesso');
								}
							}else{
								$sql = MySql::conexaobd()->prepare("INSERT INTO `avaliacoes` VALUES(null,?,?,?)");
								$sql->execute(array($nome,$conteudo,0));
								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'adicionar-avaliacoes?sucesso');
							}
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Avaliação cadastrada com sucesso!');
					}
				?>
				<div>
					<p>Nome do usuário</p>
					<input type="text" name="nome" value="<?php echo Metodos::recuperarcampopreenchido('nome'); ?>">
				</div>
				<div>
					<p>Avaliação do usuário</p>
					<textarea name="conteudo"></textarea>
				</div>
				<div>
					<p>Upload da foto do usuário (opcional)</p>
					<label id="label-foto" for="foto">Selecionar arquivo</label>
					<input id="foto" type="file" name="foto">
				</div>
				<div>
					<input type="submit" name="acao" value="Adicionar">
				</div>
			</form>
		</div>
	</div>
</section>