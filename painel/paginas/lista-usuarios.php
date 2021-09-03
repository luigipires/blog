<?php
	permissao(2);

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		$deletarfoto = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE id = ?");
		$deletarfoto->execute(array($excluir));
		$deletarfoto = $deletarfoto->fetch();

		Metodos::apagarimagemusuario($deletarfoto['foto_usuario']);
		$sql = MySql::conexaobd()->prepare("DELETE FROM `usuarios` WHERE id = ?");
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

	$cadapagina = 5;
	$query = "SELECT * FROM `usuarios` WHERE id != ?";
	$totalpaginas = MySql::conexaobd()->prepare($query);
	$totalpaginas->execute(array($_SESSION['id']));
	$totalpaginas = ceil($totalpaginas->rowCount() / $cadapagina);

	if(isset($_GET['pagina'])){
		$primeirapagina = (int)$_GET['pagina'];

		if($primeirapagina > $totalpaginas){
			$primeirapagina = 1;
		}

		$querypagina = ($primeirapagina - 1) * $cadapagina;
		$query.=" LIMIT $querypagina,$cadapagina";
	}else{
		$primeirapagina = 1;
		$query.=" LIMIT 0,$cadapagina";
	}

	$paginacao = MySql::conexaobd()->prepare($query);
	$paginacao->execute(array($_SESSION['id']));
	$paginacao = $paginacao->fetchAll();
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-user"></i></h3>
			<h2>Usuários cadastrados</h2>
		</div>
		<div class="pesquisa">
			<div>
				<input type="text" name="busca" placeholder="Procure pelo e-mail do usuário...">
				<h3><i class="fas fa-search"></i></h3>
			</div>
			<form action="<?php echo INCLUDE_PATH_PAINEL; ?>ajax/busca.php" class="ajax-busca" method="post">
				<input type="hidden" name="pesquisa-usuarios">
			</form>
		</div>
		<div class="listas">
			<table>
				<tr class="cabecalho-info">
					<td>Nome</td>
					<td>Cargo</td>
					<td></td>
					<td></td>
				</tr>
			<?php
				foreach ($paginacao as $key => $value){
					if($value['tipo_usuario'] < $_SESSION['tipousuario']){
			?>
				<tr class="tabela-informacoes">
					<td><?php echo ucfirst($value['nome']); ?> <?php echo ucfirst($value['sobrenome']); ?></td>
					<td><?php echo Metodos::$tipousuario[$value['tipo_usuario']]; ?></td>
					<td><a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-usuarios?editar=<?php echo $value['id']; ?>">
						<h3><i class="fas fa-edit"></i></h3>
						<p>Editar</p>
					</a></td>
					<td>
						<h3 iduser="<?php echo $value['id']; ?>" exclusao title="Excluir"><i class="fas fa-trash-alt"></i>Excluir</h3>
					</td>
				</tr>
			<?php
					}
				}
			?>
			</table>
		</div>

		<div class="paginas">
			<?php
				for($i = 1; $i <= $totalpaginas; $i++){
					if($i == $primeirapagina){
			?>
				<a class="selecionado" href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-usuarios?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}else{
			?>
				<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-usuarios?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
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
				<a title="Excluir" href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-usuarios?excluir=<?php echo $value['id']; ?>">
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
			<p>Usuário excluído com sucesso!</p>
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-usuarios">Retornar ao painel</a>
		</div>
	</div>
</section>