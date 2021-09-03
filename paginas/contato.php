<section>
	<div class="contato">
		<form method="post" id="formulario-contato" action="<?php echo INCLUDE_PATH; ?>ajax/dados.php">
			<div>
				<h2>Entre em contato</h2>
			</div>
			<div>
				<p>Nome</p>
				<input type="text" name="nome-contato" value="<?php echo Metodos::recuperarcampopreenchido('nome-contato'); ?>">
			</div>
			<div>
				<p>E-mail</p>
				<input type="email" name="email-contato" value="<?php echo Metodos::recuperarcampopreenchido('email-contato'); ?>">
			</div>
			<div>
				<p>Mensagem</p>
				<textarea name="mensagem-contato"><?php echo Metodos::recuperarcampopreenchido('mensagem-contato'); ?></textarea>
			</div>
			<div>
				<input type="hidden" name="acao-contato">
				<input type="submit" value="Enviar">
			</div>
		</form>
	</div>
</section>