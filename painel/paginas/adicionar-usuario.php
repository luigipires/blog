<?php
	permissao(2);
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-user-plus"></i></h3>
			<h2>Adicionar usuário</h2>
		</div>
		<div class="painel-info">
			<form method="post" enctype="multipart/form-data">
				<?php
					$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios`");
					$sql->execute();
					$sql = $sql->fetch();
					
					if(isset($_POST['acao'])){

						$nome = $_POST['nome'];
						$sobrenome = $_POST['sobrenome'];
						$email = $_POST['email'];
						$senha = $_POST['senha'];
						$tipo_usuario = $_POST['tipo_usuario'];

						if($nome == ''){
							Metodos::mensagem('erro','Você precisa colocar o nome!');
						}else if($sobrenome == ''){
							Metodos::mensagem('erro','Você precisa colocar o sobrenome!');
						}else if($email == '' || filter_var($email,FILTER_VALIDATE_EMAIL) == false || $email == $sql['email']){
							Metodos::mensagem('erro','E-mail inválido/existente!');
						}else if($senha == '' || !preg_match('/^(?=.*\d)(?=.*[A-Z])[0-9A-Za-z-_.!@#%?]{8,}$/',$senha)){
							Metodos::mensagem('erro','Senha inválida!');
						}else if($tipo_usuario == ''){
							Metodos::mensagem('erro','Tipo de usuário não foi escolhido!');
						}else{
							if($_FILES['foto']['name'] == ''){
								$sql = MySql::conexaobd()->prepare("INSERT INTO `usuarios` VALUES(null,?,?,?,?,?,?)");
								$sql->execute(array($nome,$sobrenome,$email,md5($senha),0,$tipo_usuario));
								Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'adicionar-usuario?sucesso');
							}else{
								if(Metodos::validacaoimagem($_FILES['foto']) == false){
									Metodos::mensagem('erro','Imagem inválida!');
								}else{
									$foto = Metodos::uparimagemusuario($_FILES['foto']);

									$sql = MySql::conexaobd()->prepare("INSERT INTO `usuarios` VALUES(null,?,?,?,?,?,?)");
									$sql->execute(array($nome,$sobrenome,$email,md5($senha),$foto,$tipo_usuario));
									Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'adicionar-usuario?sucesso');
								}
							}
						}
					}

					if(isset($_GET['sucesso']) && !isset($_POST['acao'])){
						Metodos::mensagem('sucesso','Usuário cadastrado com sucesso!');
					}
				?>
				<div>
					<p>Nome</p>
					<input type="text" name="nome" value="<?php echo Metodos::recuperarcampopreenchido('nome'); ?>">
				</div>
				<div>
					<p>Sobrenome</p>
					<input type="text" name="sobrenome" value="<?php echo Metodos::recuperarcampopreenchido('sobrenome'); ?>">
				</div>
				<div>
					<p>E-mail</p>
					<input type="email" name="email" value="<?php echo Metodos::recuperarcampopreenchido('email'); ?>">
				</div>
				<div class="senha-usuario">
					<div class="tooltip">
						<p>Senha</p>
						<h3><i class="fas fa-question-circle"></i></h3>

						<div>
							<div>
								<p>A senha deve conter, pelo menos, 1 letra maiúscula e 1 número</p>
							</div>
						</div>
					</div><!-- tooltip -->

					<input type="password" name="senha">
					<div class="mostrar-senha">
						<h3><i class="fas fa-eye"></i></h3>
					</div>
				</div><!-- senha-usuario -->
				<div>
					<p>Upload de foto de perfil (opcional)</p>
					<label id="label-foto" for="foto">Selecionar arquivo</label>
					<input id="foto" type="file" name="foto">
				</div>
				<div>
					<p>Atribuir categoria do usuário</p>
					<select name="tipo_usuario">
						<?php
							foreach (Metodos::$tipousuario as $key => $value){
								if($key < $_SESSION['tipousuario']){
						?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
						<?php
								}
							}
						?>
					</select>
				</div>
				<div>
					<input type="submit" name="acao" value="Adicionar">
				</div>
			</form>
		</div>
	</div>
</section>