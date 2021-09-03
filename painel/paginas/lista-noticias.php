<?php
	permissao(1,2);

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		$deletar = MySql::conexaobd()->prepare("SELECT * FROM `noticias` WHERE id = ?");
		$deletar->execute(array($excluir));
		$deletar = $deletar->fetch();

		$deletarfotos = MySql::conexaobd()->prepare("SELECT * FROM `imagens_noticias` WHERE noticia_id = ?");
		$deletarfotos->execute(array($deletar['id']));
		$deletarfotos = $deletarfotos->fetchAll();

		//apaga fotos da pasta
		foreach ($deletarfotos as $key => $value){
			Metodos::apagarimagemnoticia($value['foto_noticia']);
		}

		//exclui da tabela imagens noticias
		$deletarfotos = MySql::conexaobd()->prepare("DELETE FROM `imagens_noticias` WHERE noticia_id = ?");
		$deletarfotos->execute(array($deletar['id']));

		//exclui da tabela feedback respostas
		$deletarfeedbackResposta = MySql::conexaobd()->prepare("DELETE FROM `feedback_respostas` WHERE noticia_id = ?");
		$deletarfeedbackResposta->execute(array($deletar['id']));

		//exclui da tabela respostas
		$deletarRespostas = MySql::conexaobd()->prepare("DELETE FROM `respostas` WHERE noticia_id = ?");
		$deletarRespostas->execute(array($deletar['id']));

		//exclui da tabela feedback comentários
		$deletarfeedbackComentario = MySql::conexaobd()->prepare("DELETE FROM `feedback_comentarios` WHERE noticia_id = ?");
		$deletarfeedbackComentario->execute(array($deletar['id']));

		//exclui da tabela comentários
		$deletarComentario = MySql::conexaobd()->prepare("DELETE FROM `comentarios` WHERE noticia_id = ?");
		$deletarComentario->execute(array($deletar['id']));

		//exclui da tabela noticias
		$sql = MySql::conexaobd()->prepare("DELETE FROM `noticias` WHERE id = ?");
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

	$primeirapagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
	$cadapagina = 5;

	$paginacao = Metodos::buscarinformacoesPrincipal('noticias',($primeirapagina - 1) * $cadapagina,$cadapagina);
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-clipboard-list"></i></h3>
			<h2>Notícias cadastradas</h2>
		</div>
		<div class="listas">
			<table>
				<tr class="cabecalho-info">
					<td>Título</td>
					<td>Conteúdo</td>
					<td></td>
					<td></td>
				</tr>
			<?php
				foreach ($paginacao as $key => $value){
			?>
				<tr class="tabela-informacoes">
					<td><?php echo ucfirst($value['titulo']); ?></td>
					<td><?php echo substr(ucfirst($value['conteudo']),0,55); ?>[...]</td>
					<td><a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-noticias?editar=<?php echo $value['id']; ?>">
						<h3><i class="fas fa-edit"></i></h3>
						<p>Editar</p>
					</a></td>
					<td>
						<h3 iduser="<?php echo $value['id']; ?>" exclusao title="Excluir"><i class="fas fa-trash-alt"></i>Excluir</h3>
					</td>
				</tr>
			<?php
				}
			?>
			</table>
		</div>

		<div class="paginas">
			<?php
				$totalpaginas = ceil(count(Metodos::buscarinformacoesPrincipal('noticias')) / $cadapagina);

				for($i = 1; $i <= $totalpaginas; $i++){
					if($i == $primeirapagina){
			?>
				<a class="selecionado" href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-noticias?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}else{
			?>
				<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-noticias?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}
				}
			?>
		</div>
	</div>

	<div class="janela-excluir-imagem">
		<div class="excluir-imagem">
			<div>
				<h3><i class="fas fa-exclamation-triangle"></i></h3>
				<p>Deseja excluir esses dados?</p>
				<p>Os dados não poderão ser recuperados depois</p>
				<a title="Excluir" href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-noticias?excluir=<?php echo $value['id']; ?>">
					<h3><i class="fas fa-trash-alt"></i></h3>
					<p>Excluir dados</p>
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
			<p>Notícia excluída com sucesso!</p>
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-noticias">Retornar ao painel</a>
		</div>
	</div>
</section>