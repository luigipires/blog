<?php
	if(isset($_GET['token'])){
		$token = $_GET['token'];

		$informacao = MySql::conexaobd()->prepare("SELECT * FROM `suporte` WHERE token = ?");
		$informacao->execute(array($token));
		$informacao = $informacao->fetch();

		$suporte = MySql::conexaobd()->prepare("SELECT * FROM `comunicacao_suporte` WHERE token_usuario = ?");
		$suporte->execute(array($token));
		$suporte = $suporte->fetchAll();
	}else{
		Metodos::mensagem('alerta','Você precisa do token!');
		die();
	}
?>
<section>
	<div class="padrao-pagina">
		<div>
			<h3><i class="fas fa-comment"></i></h3>
			<h2>Histórico da conversa</h2>
		</div>
		<div class="pergunta">
			<p>Pergunta: <?php echo ucfirst($informacao['pergunta']); ?></p>
			<?php
				if($informacao['explicacao'] != ''){
			?>
			<p>Explicação: <?php echo ucfirst($informacao['explicacao']); ?></p>
			<?php
				}
			?>
		</div>
		<?php
			foreach ($suporte as $key => $value){
				if($value['identificacao_usuario'] == -1){
					$usuario = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE id = ?");
					$usuario->execute(array($informacao['usuario_id']));
					$usuario = $usuario->fetch();
		?>
		<div class="suporte">
			<p><b><?php echo ucfirst($usuario['nome']); ?>:</b> <?php echo ucfirst($value['resposta']); ?></p>
		</div>
		<?php
				}else{
		?>
		<div class="suporte">
			<p><b>Administrador:</b> <?php echo ucfirst($value['resposta']); ?></p>
		</div>
		<?php
				}
			}
		?>
	</div>
</section>