<?php
	permissao(1,2);

	$primeirapagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
	$cadapagina = 5;

	$paginacao = Metodos::buscarinformacoesPrincipal('suporte',($primeirapagina - 1) * $cadapagina,$cadapagina);

	if(isset($_GET['concluido'])){
		$sql = MySql::conexaobd()->prepare("UPDATE `suporte` SET status_andamento = ? WHERE token = ?");
		$sql->execute(array(0,$_GET['token']));
		sleep(2);
		Metodos::redirecionamentoespecifico(INCLUDE_PATH_PAINEL.'resposta-suporte');
	}
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
					<td><a href="<?php echo INCLUDE_PATH_PAINEL; ?>comunicacao_suporte_admin?token=<?php echo $value['token']; ?>">
						<h3><i class="fas fa-eye"></i></h3>
						<p>Visualizar</p>
					</a></td>
					<?php
						if($value['status_andamento'] == 1){
					?>
					<td><a style="background-color: #26965b;" href="<?php echo INCLUDE_PATH_PAINEL; ?>resposta-suporte?token=<?php echo $value['token']; ?>&concluido">
						<h3><i class="fas fa-check"></i></h3>
						<p>Concluído</p>
					</a></td>
					<?php
						}else{
					?>
					<td><a style="background-color: #26965b; opacity: 0.3; cursor: not-allowed;">
						<h3><i class="fas fa-check"></i></h3>
						<p>Concluído</p>
					</a></td>
					<?php
						}
					?>
				</tr>
			<?php
				}
			?>
			</table>
		</div>

		<div class="paginas">
			<?php
				$totalpaginas = ceil(count(Metodos::buscarinformacoesPrincipal('suporte')) / $cadapagina);

				for($i = 1; $i <= $totalpaginas; $i++){
					if($i == $primeirapagina){
			?>
				<a class="selecionado" href="<?php echo INCLUDE_PATH_PAINEL; ?>resposta-suporte?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}else{
			?>
				<a href="<?php echo INCLUDE_PATH_PAINEL; ?>resposta-suporte?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}
				}
			?>
		</div>
	</div>
</section>