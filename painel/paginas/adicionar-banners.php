<?php
	permissao(2);
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-image"></i></h3>
			<h2>Adicionar banners</h2>
		</div>
		<div class="painel-info">
			<form method="post" enctype="multipart/form-data">
				<?php
					if(isset($_POST['acao'])){

						$titulo = $_POST['titulo'];
						$fotos = [];
						$fotosbanner = count($_FILES['foto']['name']);
						$funcionamento = true;

						if($titulo == ''){
							Metodos::mensagem('erro','Você precisa colocar o título!');
						}else if($_FILES['foto']['name'][0] == ''){
							Metodos::mensagem('erro','Você precisa escolher uma foto!');
						}else{
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
									$fotos[] = Metodos::uparimagembanner($fotosupadas);
								}

								$ativacao = null;

								$verificacao = MySql::conexaobd()->prepare("SELECT * FROM `banners` WHERE ativo = ?");
								$verificacao->execute(array(1));

								if($verificacao->rowCount() == 1){
									$ativacao = 0;
								}else{
									$ativacao = 1;
								}

								$sql = MySql::conexaobd()->prepare("INSERT INTO `banners` VALUES(null,?,?)");
								$sql->execute(array($titulo,$ativacao));
								$id = MySql::conexaobd()->lastInsertId();

								foreach ($fotos as $key => $value){
									$sql2 = MySql::conexaobd()->prepare("INSERT INTO `imagens_banners` VALUES(null,?,?)");
									$sql2->execute(array($id,$value));
								}

								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'adicionar-banners?sucesso');
							}
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Banner cadastrado com sucesso!');
					}
				?>
				<div>
					<p>Título do banner</p>
					<input type="text" name="titulo" value="<?php echo Metodos::recuperarcampopreenchido('titulo'); ?>">
				</div>
				<div>
					<p>Upload de fotos</p>
					<label id="label-foto" for="foto">Selecionar arquivos</label>
					<input id="foto" multiple type="file" name="foto[]">
				</div>
				<div>
					<input type="submit" name="acao" value="Adicionar">
				</div>
			</form>
		</div>
	</div>
</section>