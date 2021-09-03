<?php
	permissao(2);
	
	if(isset($_GET['editar'])){
		$id = (int)$_GET['editar'];

		$banners = MySql::conexaobd()->prepare("SELECT * FROM `banners` WHERE id = ?");
		$banners->execute(array($id));
		$banners = $banners->fetch();

		$imagensbanners = MySql::conexaobd()->prepare("SELECT * FROM `imagens_banners` WHERE banner_id = ?");
		$imagensbanners->execute(array($banners['id']));
		$imagensbanners = $imagensbanners->fetchAll();
	}else{
		Metodos::mensagem('alerta','Você precisa do ID!');
		die();
	}

	if(isset($_GET['excluir'])){
		$excluir = (int)$_GET['excluir'];

		$imagensbanners2 = MySql::conexaobd()->prepare("SELECT * FROM `imagens_banners` WHERE id = ?");
		$imagensbanners2->execute(array($excluir));
		$imagensbanners2 = $imagensbanners2->fetch();

		Metodos::apagarimagemusuario($imagensbanners2['foto_banner']);

		$sql = MySql::conexaobd()->prepare("DELETE FROM `imagens_banners` WHERE id = ?");
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
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-file-image"></i></h3>
			<h2>Editar banners</h2>
		</div>
		<div class="painel-info">
			<form method="post" enctype="multipart/form-data">
				<?php
					if(isset($_POST['acao'])){
						$titulo = $_POST['titulo'];
						$fotos = [];
						$fotosbanner = '';
						$funcionamento = true;

						if($titulo == ''){
							Metodos::mensagem('erro','Você precisa colocar o título!');
						}else if($_FILES['foto']['name'][0] != ''){
							$fotosbanner = count($_FILES['foto']['name']);

							for($i = 0; $i < $fotosbanner; $i++){
								$fotosupadas = ['type'=>$_FILES['foto']['type'][$i],'size'=>$_FILES['foto']['size'][$i]];

								if(Metodos::validacaoimagem($fotosupadas) == false){
									Metodos::mensagem('erro','Uma das fotos não é válida!');
									$funcionamento = false;
									break;
								}
							}

							if($funcionamento == true){
								for($i = 0; $i < $fotosbanner; $i++){
									$fotosupadas = ['tmp_name'=>$_FILES['foto']['tmp_name'][$i],'name'=>$_FILES['foto']['name'][$i]];
									$foto[] = Metodos::uparimagembanner($fotosupadas);
								}

								$sql = MySql::conexaobd()->prepare("UPDATE `banners` SET titulo_banner = ? WHERE id = ?");
								$sql->execute(array($titulo,$id));

								foreach ($foto as $key => $value){
									$sql2 = MySql::conexaobd()->prepare("INSERT INTO `imagens_banners` VALUES(null,?,?)");
									$sql2->execute(array($id,$value));
								}

								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-banners?editar='.$id.'&sucesso');
							}
						}else{
							$sql = MySql::conexaobd()->prepare("UPDATE `banners` SET titulo_banner = ? WHERE id = ?");
							$sql->execute(array($titulo,$id));
							Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'editar-banners?editar='.$id.'&sucesso');
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Conjunto atualizado com sucesso!');
					}
				?>
				<div>
					<p>Título do conjunto</p>
					<input type="text" name="titulo" value="<?php echo $banners['titulo_banner']; ?>">
				</div>
				<div class="foto-imagens-atual">
					<p>Imagens do conjunto</p>
					<div>
						<?php
							foreach ($imagensbanners as $key => $value){
						?>
							<div class="exposicao-fotos">
								<div>
									<div style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/banners/<?php echo $value['foto_banner']; ?>');"></div>
									<h3 idimagem="<?php echo $value['id']; ?>" exclusaoimagemmultiple title="Excluir foto"><i class="fas fa-trash-alt"></i></h3>
								</div>
							</div>
						<?php
							}
						?>
					</div>
				</div>
				<div>
					<p>Upload de fotos</p>
					<label id="label-foto" for="foto">Selecionar arquivos</label>
					<input multiple id="foto" type="file" name="foto[]">
				</div>
				<div>
					<input type="submit" name="acao" value="Atualizar">
				</div>
			</form>
		</div>
	</div>

	<div class="janela-excluir-imagem">
		<div class="excluir-imagem">
			<div>
				<h3><i class="fas fa-exclamation-triangle"></i></h3>
				<p>Deseja excluir essa imagem?</p>
				<p>A imagem não poderá ser recuperada depois</p>
				<a title="Excluir foto" href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-banners?editar=<?php echo $id; ?>&excluir=<?php echo $value['id']; ?>">
					<h3><i class="fas fa-trash-alt"></i></h3>
					<p>Excluir foto</p>
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
			<p>Imagem excluída com sucesso!</p>
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-banners?editar=<?php echo $id; ?>">Retornar ao painel</a>
		</div>
	</div>
</section>