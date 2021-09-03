<?php
	if(isset($_SESSION['login'])){
		Metodos::redirecionamentoespecifico(INCLUDE_PATH);
	}
?>
<section>
	<div class="cadastro">
		<form id="cadastro-formulario" method="post" enctype="multipart/form-data" action="<?php echo INCLUDE_PATH; ?>ajax/dados.php">
			<div>
				<h2>Faça sua conta</h2>
			</div>
			<div class="form-cadastro">
				<p>Nome</p>
				<input type="text" name="nome-cadastro">
			</div><!-- form-cadastro -->
			<div>
				<p>Sobrenome</p>
				<input type="text" name="sobrenome-cadastro">
			</div>
			<div>
				<p>E-mail</p>
				<input type="email" name="email-cadastro">
			</div>
			<div style="position: relative;">
				<div class="tooltip">
					<p>Senha</p>
					<h3><i class="fas fa-question-circle"></i></h3>
					
					<div>
						<div>
							<p>A senha deve conter, pelo menos, 1 letra maiúscula e 1 número</p>
						</div>
					</div>
				</div><!-- tooltip -->

				<input type="password" name="password-cadastro">
				<div class="mostrar-senha">
					<h3><i class="fas fa-eye"></i></h3>
				</div>
			</div>
			<div>
				<p>Foto de perfil (opcional)</p>
				<label id="label-foto" for="foto">Selecionar arquivo</label>
				<input id="foto" type="file" name="foto">
			</div>
			<div>
				<input type="hidden" name="tipo-usuario" value="0">
				<input type="hidden" name="acao-cadastro">
				<input type="submit" value="Cadastrar">
			</div>
		</form><!-- cadastro-formulario -->
	</div><!-- cadastro -->
</section>