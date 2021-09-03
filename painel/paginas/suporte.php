<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-comments"></i></h3>
			<h2>Suporte</h2>
		</div>
		<div class="painel-info">
			<form method="post" enctype="multipart/form-data">
				<?php
					if(isset($_POST['acao'])){
						$pergunta = $_POST['pergunta'];
						$conteudo = $_POST['conteudo'];
						$token = uniqid();

						if($pergunta == ''){
							Metodos::mensagem('erro','Campo vazio!');
						}else{
							if($conteudo != ''){
								$sql = MySql::conexaobd()->prepare("INSERT INTO `suporte` VALUES(null,?,?,?,?,?)");
								$sql->execute(array($_SESSION['id'],$pergunta,$conteudo,$token,1));
								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'suporte?sucesso');
							}else{
								$sql = MySql::conexaobd()->prepare("INSERT INTO `suporte` VALUES(null,?,?,?,?)");
								$sql->execute(array($_SESSION['id'],$pergunta,$token,1));
								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'suporte?sucesso');
							}
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Pergunta enviada com sucesso!');
					}
				?>
				<div>
					<p>Como podemos te ajudar?</p>
					<input type="text" name="pergunta" value="<?php echo Metodos::recuperarcampopreenchido('pergunta'); ?>">
				</div>
				<div>
					<p>Se quiser explicar sua pergunta, escreva abaixo <b>(opcional)</b></p>
					<textarea name="conteudo"><?php echo Metodos::recuperarcampopreenchido('conteudo'); ?></textarea>
				</div>
				<div>
					<input type="submit" name="acao" value="Enviar">
				</div>
			</form>
		</div>
	</div>
</section>