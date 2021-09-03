<?php
	permissao(2);

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		$informacao = MySql::conexaobd()->prepare("SELECT * FROM `avaliacoes` WHERE id = ?");
		$informacao->execute(array($excluir));
		$informacao = $informacao->fetch();

		Metodos::apagarimagemavaliacao($informacao['foto_usuario']);
		$sql = MySql::conexaobd()->prepare("DELETE FROM `avaliacoes` WHERE id = ?");
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

	$paginacao = Metodos::buscarinformacoesPrincipal('avaliacoes',($primeirapagina - 1) * $cadapagina,$cadapagina);
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-list-alt"></i></h3>
			<h2>Avaliações cadastradas</h2>
		</div>
		<div class="listas">
			<table>
				<tr class="cabecalho-info">
					<td>Nome do usuário</td>
					<td>Avaliação</td>
					<td></td>
					<td></td>
				</tr>
			<?php
				foreach ($paginacao as $key => $value){
			?>
				<tr class="tabela-informacoes">
					<td><?php echo ucfirst($value['nome_usuario']); ?></td>
					<td><?php echo substr(ucfirst($value['conteudo']),0,50); ?>[...]</td>
					<td><a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-avaliacoes?editar=<?php echo $value['id']; ?>">
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
				$totalpaginas = ceil(count(Metodos::buscarinformacoesPrincipal('avaliacoes')) / $cadapagina);

				for($i = 1; $i <= $totalpaginas; $i++){
					if($i == $primeirapagina){
			?>
				<a class="selecionado" href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-avaliacoes?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}else{
			?>
				<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-avaliacoes?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
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
				<a title="Excluir" href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-avaliacoes?excluir=<?php echo $value['id']; ?>">
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
			<p>Dados excluídos com sucesso!</p>
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-avaliacoes">Retornar ao painel</a>
		</div>
	</div>
</section>