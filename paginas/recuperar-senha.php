<section>
	<div class="recuperar-senha">
		<form method="post">
			<div>
				<h2>Recuperar senha</h2>
			</div>
			<?php
				if(isset($_POST['acao'])){
					$email = $_POST['email-recuperacao'];
					$token = uniqid();
					$_SESSION['token_redefinir'] = $token;

					if($email == '' || filter_var($email,FILTER_VALIDATE_EMAIL) == false){
						Metodos::mensagem('erro','E-mail inválido!');
					}else{
						$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE email = ?");
						$sql->execute(array($email));

						if($sql->rowCount() == 1){
							$_SESSION['emailredefinir'] = $email;
							Metodos::mensagem('alerta','E-mail enviado. Clique <a href="'.INCLUDE_PATH.'redefinir-senha?token='.$token.'">aqui</a> para redefinir sua senha.');
						}else{
							Metodos::mensagem('erro','E-mail não encontrado!');
						}
					}
				}
			?>
			<div>
				<p>Insira seu e-mail</p>
				<input type="email" name="email-recuperacao">
			</div>
			<div>
				<input type="submit" name="acao" value="Enviar">
			</div>
		</form>
	</div>
</section>