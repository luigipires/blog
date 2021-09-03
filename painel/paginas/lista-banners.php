<?php
	permissao(2);

	if(isset($_GET['ativar'])){
		$ativar = (int)$_GET['ativar'];
		$update = MySql::conexaobd()->prepare("UPDATE `banners` SET ativo = ? WHERE id = ?");
		$update->execute(array(1,$ativar));
		Metodos::redirecionamentoespecifico(INCLUDE_PATH_PAINEL.'lista-banners');
	}

	if(isset($_GET['desativar'])){
		$desativar = (int)$_GET['desativar'];
		$update = MySql::conexaobd()->prepare("UPDATE `banners` SET ativo = ? WHERE id = ?");
		$update->execute(array(0,$desativar));
		Metodos::redirecionamentoespecifico(INCLUDE_PATH_PAINEL.'lista-banners');
	}

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		$deletar = MySql::conexaobd()->prepare("SELECT * FROM `banners` WHERE id = ?");
		$deletar->execute(array($excluir));
		$deletar = $deletar->fetch();

		$deletarfotos = MySql::conexaobd()->prepare("SELECT * FROM `imagens_banners` WHERE banner_id = ?");
		$deletarfotos->execute(array($deletar['id']));
		$deletarfotos = $deletarfotos->fetchAll();

		foreach ($deletarfotos as $key => $value){
			Metodos::apagarimagembanner($value['foto_banner']);
		}

		$deletarfotos = MySql::conexaobd()->prepare("DELETE FROM `imagens_banners` WHERE banner_id = ?");
		$deletarfotos->execute(array($deletar['id']));

		$sql = MySql::conexaobd()->prepare("DELETE FROM `banners` WHERE id = ?");
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

	$paginacao = Metodos::buscarinformacoesPrincipal('banners',($primeirapagina - 1) * $cadapagina,$cadapagina);
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-images"></i></h3>
			<h2>Banners cadastrados</h2>
		</div>
		<div class="listas">
			<table>
				<tr class="cabecalho-info">
					<td>Nome do grupo</td>
					<td>Fotos do banner</td>
					<td></td>
					<td></td>
				</tr>
			<?php
				foreach ($paginacao as $key => $value){
			?>
				<tr class="tabela-informacoes">
					<td><?php echo ucfirst($value['titulo_banner']); ?></td>
					<?php
						if($value['ativo'] == 0){
							$verificacao = MySql::conexaobd()->prepare("SELECT * FROM `banners` WHERE ativo = ?");
							$verificacao->execute(array(1));

							if($verificacao->rowCount() == 0){
					?>
					<td>
						<a activate href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-banners?ativar=<?php echo $value['id']; ?>">
							<h3><i class="fas fa-check"></i></h3>
							<p>Ativar fotos</p>
						</a>
					</td>
					<?php
							}else{
					?>
					<td>
						<a desactivated>
							<h3><i class="fas fa-check"></i></h3>
							<p>Ativar fotos</p>
						</a>
					</td>
					<?php
							}
						}else{
					?>
					<td>
						<a desactivate href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-banners?desativar=<?php echo $value['id']; ?>">
							<h3><i class="fas fa-ban"></i></h3>
							<p>Desativar fotos</p>
						</a>
					</td>
					<?php
						}
					?>
					<td><a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-banners?editar=<?php echo $value['id']; ?>">
						<h3><i class="fas fa-edit"></i></h3>
						<p>Editar</p>
					</a></td>
					<td>
						<h3 iduser="<?php echo $value['id']; ?>" exclusao="excluir" title="Excluir"><i class="fas fa-trash-alt"></i>Excluir</h3>
					</td>
				</tr>
			<?php
				}
			?>
			</table>
		</div>

		<div class="paginas">
			<?php
				$totalpaginas = ceil(count(Metodos::buscarinformacoesPrincipal('banners')) / $cadapagina);

				for($i = 1; $i <= $totalpaginas; $i++){
					if($i == $primeirapagina){
			?>
				<a class="selecionado" href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-banners?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}else{
			?>
				<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-banners?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
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
				<a title="Excluir" href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-banners?excluir=<?php echo $value['id']; ?>">
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
			<p>Banners excluídos com sucesso!</p>
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-banners">Retornar ao painel</a>
		</div>
	</div>
</section>