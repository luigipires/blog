<?php
	permissao(1,2);

	$comentario = MySql::conexaobd()->prepare("SELECT * FROM `comentarios` WHERE denuncia != ?");
	$comentario->execute(array(0));
	$comentario = $comentario->fetchAll();

	$resposta = MySql::conexaobd()->prepare("SELECT * FROM `respostas` WHERE denuncia != ?");
	$resposta->execute(array(0));
	$resposta = $resposta->fetchAll();
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-flag"></i></h3>
			<h2>Menu de denúncias</h2>
		</div>

		<div class="painel-info">
			<div class="button-denuncia">
				<div>
					<?php
						if(count($comentario) != 0){
					?>
					<a href="<?php echo INCLUDE_PATH_PAINEL; ?>denuncia-comentario">
						<h3><i class="fas fa-flag"></i></h3>
						<p>Ver comentários denunciados</p>
						<span><?php echo count($comentario); ?></span>
					</a>
					<?php
						}else{
					?>
					<a style="cursor: not-allowed; background-color: #AA5642;">
						<h3><i class="fas fa-flag"></i></h3>
						<p>Ver comentários denunciados</p>
					</a>
					<?php
						}
					?>
				</div>

				<div>
					<?php
						if(count($resposta) != 0){
					?>
					<a href="<?php echo INCLUDE_PATH_PAINEL; ?>denuncia-resposta">
						<h3><i class="fas fa-flag"></i></h3>
						<p>Ver respostas denunciadas</p>
						<span><?php echo count($resposta); ?></span>
					</a>
					<?php
						}else{
					?>
					<a style="cursor: not-allowed; background-color: #AA5642;">
						<h3><i class="fas fa-flag"></i></h3>
						<p>Ver respostas denunciadas</p>
					</a>
					<?php
						}
					?>
				</div>
			</div><!-- button-denuncia -->
		</div><!-- painel-info -->
	</div><!-- padrao-pagina -->
</section>