<?php
	permissao(1,2);
	
	if(isset($_GET['editar'])){
		$id = (int)$_GET['editar'];

		$informacao = MySql::conexaobd()->prepare("SELECT * FROM `categorias_noticia` WHERE id = ?");
		$informacao->execute(array($id));
		$informacao = $informacao->fetch();
	}else{
		Metodos::mensagem('alerta','Você precisa do ID!');
		die();
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
							Metodos::mensagem('erro','Você precisa inserir a descrição!');
						}else{
							$url = Metodos::gerarurl($nome);
							$sql = MySql::conexaobd()->prepare("UPDATE `categorias_noticia` SET nome_categoria = ?, descricao = ?, url = ? WHERE id = ?");
							$sql->execute(array($nome,$conteudo,$url,$id));
							Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-categorias?editar='.$id.'&sucesso');
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Categoria atualizada com sucesso!');
					}
				?>
				<div>
					<p>Nome da categoria</p>
					<input type="text" name="nome" value="<?php echo $informacao['nome_categoria']; ?>">
				</div>
				<div>
					<p>Descrição da categoria</p>
					<textarea name="conteudo"><?php echo ucfirst($informacao['descricao']); ?></textarea>
				</div>
				<div>
					<input type="submit" name="acao" value="Atualizar">
				</div>
			</form>
		</div>
	</div>
</section>