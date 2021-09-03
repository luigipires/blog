<?php
	permissao(1,2);
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-pen"></i></h3>
			<h2>Adicionar categorias</h2>
		</div>
		<div class="painel-info">
			<form method="post">
				<?php
					if(isset($_POST['acao'])){
						$nome = $_POST['nome'];
						$conteudo = $_POST['conteudo'];

						if($nome == ''){
							Metodos::mensagem('erro','Você precisa colocar o nome!');
						}else if($conteudo == ''){
							Metodos::mensagem('erro','Você precisa colocar a descrição!');
						}else{
							$url = Metodos::gerarurl($nome);
							$sql = MySql::conexaobd()->prepare("INSERT INTO `categorias_noticia` VALUES(null,?,?,?)");
							$sql->execute(array($nome,$conteudo,$url));
							Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'adicionar-categorias?sucesso');
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Categoria cadastrada com sucesso!');
					}
				?>
				<div>
					<p>Nome da categoria</p>
					<input type="text" name="nome" value="<?php echo Metodos::recuperarcampopreenchido('nome'); ?>">
				</div>
				<div>
					<p>Descrição da categoria</p>
					<textarea name="conteudo"></textarea>
				</div>
				<div>
					<input type="submit" name="acao" value="Adicionar">
				</div>
			</form>
		</div>
	</div>
</section>