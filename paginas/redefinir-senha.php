<?php 
	if(isset($_GET['token'])){
		$token = $_GET['token'];

		if($token != $_SESSION['token_redefinir']){
			Metodos::redirecionamentoespecifico(INCLUDE_PATH);
		}
	}
 ?>
<section>
	<div class="redefinir-senha">
		<form method="post">
			<div>
				<h2>Redefinir senha</h2>
			</div>
			<?php
				if(isset($_POST['acao'])){
					$senha = $_POST['redefinir-senha'];

					if($senha == '' || !preg_match('/^[a-zA-z0-9.*-_]{8,}$/',$senha)){
						Metodos::mensagem('erro','Senha inválida!');
					}else{
						$sql = MySql::conexaobd()->prepare("UPDATE `usuarios` SET senha = ? WHERE email = ?");
						$sql->execute(array(md5($senha),$_SESSION['emailredefinir']));
						Metodos::mensagem('sucesso','Senha alterada com sucesso!');
						unset($_SESSION['emailredefinir']);
					}
				}
			?>
			<div style="position: relative;">
				<p>Senha</p>
				<input type="password" name="redefinir-senha">
				<div class="mostrar-senha">
					<h3><i class="fas fa-eye"></i></h3>
				</div>
			</div>
			<div>
				<input type="submit" name="acao" value="Atualizar">
			</div>
		</form>
	</div>
</section>