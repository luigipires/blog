<?php
	permissao(1,2);

	$info = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE denuncia != ?");
	$info->execute(array(0));

	if($info->rowCount() == 0){
		Metodos::redirecionamentoespecifico(INCLUDE_PATH_PAINEL);
	}

	//excluir informação
	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		$informacao = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE id = ?");
		$informacao->execute(array($excluir));
		$informacao = $informacao->fetch();

		//exclui da tabela feedback respostas
		$deletarfeedbackResposta = MySql::conexaobd()->prepare("DELETE FROM `feedback_respostas` WHERE comentario_id = ?");
		$deletarfeedbackResposta->execute(array($excluir));

		//exclui da tabela respostas
		$deletarRespostas = MySql::conexaobd()->prepare("DELETE FROM `respostas` WHERE comentario_id = ?");
		$deletarRespostas->execute(array($excluir));

		//exclui da tabela feedback comentários
		$deletarfeedbackComentario = MySql::conexaobd()->prepare("DELETE FROM `feedback_comentarios` WHERE comentario_id = ?");
		$deletarfeedbackComentario->execute(array($excluir));

		//exclui da tabela comentários
		$deletarComentario = MySql::conexaobd()->prepare("DELETE FROM `comentarios` WHERE id = ?");
		$deletarComentario->execute(array($excluir));
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

	//fazendo paginação
	$cadapagina = 5;
	$query = "SELECT * FROM `comentarios` WHERE denuncia != ?";
	$totalpaginas = MySql::conexaobd()->prepare($query);
	$totalpaginas->execute(array(0));
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
	$paginacao->execute(array(0));
	$paginacao = $paginacao->fetchAll();

	//resetando denúncias
	if(isset($_GET['remover'])){
		$remover = (int)$_GET['remover'];

		$sql = MySql::conexaobd()->prepare("UPDATE `comentarios` SET denuncia = ? WHERE id = ?");
		$sql->execute(array(0,$remover));
		sleep(1);

		$info = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE denuncia != ?");
		$info->execute(array(0));

		if($info->rowCount() >= 1){
			Metodos::redirecionamentoespecifico(INCLUDE_PATH_PAINEL.'denuncia-comentario');
		}else{
			Metodos::redirecionamentoespecifico(INCLUDE_PATH_PAINEL);
		}
	}
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-flag"></i></h3>
			<h2>Denúncias de comentários</h2>
		</div>
		<div class="listas">
			<table>
				<tr class="cabecalho-info">
					<td>Comentário</td>
					<td>Gravidade</td>
					<td>Tirar denúncias</td>
					<td></td>
				</tr>
			<?php
				foreach ($paginacao as $key => $value){
			?>
				<tr class="tabela-informacoes">
					<td>
						<a idComent="<?php echo $value['comentario']; ?>" view>
							<h3><i class="fas fa-eye"></i></h3>
							<p>Ver</p>
						</a>
					</td>
					<?php
						if($value['denuncia'] >= 1 && $value['denuncia'] < 10){
					?>
					<td style="color:#FF4646">Moderado</td>
					<?php
						}else if($value['denuncia'] >= 10 && $value['denuncia'] < 20){
					?>
					<td style="color:#CC0000">Problemático</td>
					<?php
						}else if($value['denuncia'] >= 20){
					?>
					<td style="color:#CC0000;font-weight: bold;">Grave</td>
					<?php
						}
					?>
					<td>
						<a remove title="Remover denúncias" href="<?php echo INCLUDE_PATH_PAINEL; ?>denuncia-comentario?remover=<?php echo $value['id']; ?>">
							<h3><i class="fas fa-align-slash"></i></h3>
							<p>Remover</p>
						</a>
					</td>
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
				for($i = 1; $i <= $totalpaginas; $i++){
					if($i == $primeirapagina){
			?>
				<a class="selecionado" href="<?php echo INCLUDE_PATH_PAINEL; ?>denuncia-comentario?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}else{
			?>
				<a href="<?php echo INCLUDE_PATH_PAINEL; ?>denuncia-comentario?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
			<?php
					}
				}
			?>
		</div><!-- paginas -->
	</div>

	<div class="janela-excluir-imagem">
		<div class="excluir-imagem">
			<div>
				<h3><i class="fas fa-exclamation-triangle"></i></h3>
				<p>Deseja excluir esses dados?</p>
				<p>Os dados não poderão ser recuperados depois</p>
				<a title="Excluir" href="<?php echo INCLUDE_PATH_PAINEL; ?>denuncia-comentario?excluir=<?php echo $value['id']; ?>">
					<h3><i class="fas fa-trash-alt"></i></h3>
					<p>Excluir comentário</p>
				</a>

				<div class="fechar-janela">
					<img title="Fechar" src="<?php echo INCLUDE_PATH; ?>imagens/x.png">
				</div><!-- fechar-janela -->
			</div>
		</div><!-- excluir-imagem -->
	</div><!-- janela-excluir-imagem -->

	<div class="janela-sucesso-imagem">
		<div class="sucesso-janela">
			<h3><i class="fas fa-check-circle"></i></h3>
			<p>Comentário excluído com sucesso!</p>
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>denuncia-comentario">Retornar ao painel</a>
		</div>
	</div><!-- janela-sucesso-imagem -->

	<div class="subir-comentario">
		<div class="box-comentario">
			<h2>Comentário denunciado</h2>
			<p></p>

			<div class="fechar-janela">
				<img title="Fechar" src="<?php echo INCLUDE_PATH; ?>imagens/x.png">
			</div><!-- fechar-janela -->
		</div><!-- box-comentario -->
	</div>
</section>