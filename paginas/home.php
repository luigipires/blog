<section>
	<div class="sessao-galeria-fotos">
		<?php
			$fotosbanners = MySql::conexaobd()->prepare("SELECT * FROM `banners`");
			$fotosbanners->execute();

			if($fotosbanners->rowCount() == 0){
		?>
		<div style="background-image: url('<?php echo INCLUDE_PATH; ?>painel/imagens/sem-foto.jpg');"></div>
		<?php
			}else{
				$fotos = MySql::conexaobd()->prepare("SELECT * FROM `banners` WHERE ativo = ?");
				$fotos->execute(array(1));
				$fotos = $fotos->fetch();
		
				if($fotos['ativo'] == 1){
					$imagensbanners = MySql::conexaobd()->prepare("SELECT * FROM `imagens_banners` WHERE banner_id = ?");
					$imagensbanners->execute(array($fotos['id']));
					$imagensbanners = $imagensbanners->fetchAll();

					foreach ($imagensbanners as $key2 => $value2){
		?>
		<div fotos="fotos" style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/banners/<?php echo $value2['foto_banner']; ?>');"></div><!-- fotos -->
		<div class="banner-slide"></div>
		<?php
					}
				}else{
					$fotos = MySql::conexaobd()->prepare("SELECT * FROM `banners` WHERE ativo = ? ORDER BY id ASC");
					$fotos->execute(array(0));
					$fotos = $fotos->fetch();

					$imagensbanners = MySql::conexaobd()->prepare("SELECT * FROM `imagens_banners` WHERE banner_id = ?");
					$imagensbanners->execute(array($fotos['id']));
					$imagensbanners = $imagensbanners->fetchAll();

					foreach ($imagensbanners as $key3 => $value3){
		?>
		<div fotos="fotos" style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/banners/<?php echo $value3['foto_banner']; ?>');"></div><!-- fotos -->
		<div class="banner-slide"></div>
		<?php
					}
				}
			}
		?>
	</div><!-- sessao-galeria-fotos -->
</section>

<section>
	<div class="global-descricao">
		<h2>Chame pelos nossos serviços</h2>
		<div class="descricao">
			<div class="info-descricao">
				<h3><i class="fas fa-comment-dots"></i></h3>
				<h4>Suporte personalizado</h4>
				<p>Lorem ipsum</p>
			</div><!-- info-descricao -->

			<div class="info-descricao">
				<h3><i class="fas fa-tachometer-alt"></i></h3>
				<h4>Atendimento rápido</h4>
				<p>Lorem ipsum</p>
			</div><!-- info-descricao -->

			<div class="info-descricao">
				<h3><i class="fas fa-money-bill-wave"></i></h3>
				<h4>Baixo custo de investimento</h4>
				<p>Lorem ipsum</p>
			</div><!-- info-descricao -->
		</div><!-- descricao -->
	</div><!-- global-descricao -->
</section>

<section>
	<div class="global-avaliacoes">
		<h2>Veja as avaliações dos nossos clientes</h2>
		<div class="avaliacoes">
			<div class="box-avaliacoes">
				<?php
					$avaliacoes = MySql::conexaobd()->prepare("SELECT * FROM `avaliacoes`");
					$avaliacoes->execute();
					$avaliacoes = $avaliacoes->fetchAll();

					foreach ($avaliacoes as $key4 => $value4){
				?>
				<div class="info-avaliacao">
					<div class="descricao-avaliacao">
						<p><?php echo ucfirst($value4['conteudo']); ?></p>
						<div class="quote"></div>
					</div><!-- descricao-avaliacao -->
					
					<div class="foto-avaliador">
						<?php
							if($value4['foto_usuario'] != 0){
						?>
						<div class="user-foto">
							<div style="background-image: url('<?php echo INCLUDE_PATH; ?>painel/imagens/avaliacoes/<?php echo $value4['foto_usuario']; ?>');"></div>
						</div><!-- user-foto -->
						<?php
							}else{
						?>
						<div class="anonymous-foto">
							<h3><i class="fas fa-user"></i></h3>
						</div><!-- anonymous-foto -->
						<?php
							}
						?>
						<div class="nomeUser">
							<h4><?php echo ucfirst($value4['nome_usuario']); ?></h4>
						</div><!-- nomeUser -->

						<div class="clear"></div>
					</div><!-- foto-avaliador -->
				</div><!-- info-avaliacao -->
				<?php
					}
				?>
			</div><!-- box-avaliacoes -->
		</div><!-- avaliacoes -->
	</div><!-- global-avaliacoes -->
</section>