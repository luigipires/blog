<?php
	$cadapagina = 5;
	$query = "SELECT * FROM `suporte` WHERE usuario_id = ?";
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
			<h3><i class="fas fa-comment-lines"></i></h3>
			<h2>Chamados feitos para o suporte</h2>
		</div>
		<div class="listas">
			<table>
				<tr class="cabecalho-info">
					<td>Chamado</td>
					<td>Status</td>
					<td></td>
				</tr>
			<?php
				foreach ($paginacao as $key => $value){
			?>
				<tr class="tabela-informacoes">
					<td><?php echo ucfirst($value['pergunta']); ?></td>
					<?php
						if($value['status_andamento'] == 1){
					?>
					<td>Em andamento</td>
					<?php
						}else{
					?>
					<td>Encerrado</td>
					<?php
						}
					?>
					<td><a href="<?php echo INCLUDE_PATH_PAINEL; ?>comunicacao_suporte?token=<?php echo $value['token']; ?>">
						<h3><i class="fas fa-eye"></i></h3>
						<p>Visualizar</p>
					</a></td>
				</tr>
			<?php
				}
			?>
			</table>
		</div>

		<div class="paginas">
			<?php
				for($i = 1; $i <= $totalpaginas; $i++){
					if($i == $primeirapagina){
			?>
				<a class="selecionado" href="<?php echo INCLUDE_PATH_PAINEL; ?>mensagens-suporte?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}else{
			?>
				<a href="<?php echo INCLUDE_PATH_PAINEL; ?>mensagens-suporte?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}
				}
			?>
		</div>
	</div>
</section>