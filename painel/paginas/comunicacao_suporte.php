<?php
	if(isset($_GET['token'])){
		$token = $_GET['token'];

		$informacao = MySql::conexaobd()->prepare("SELECT * FROM `suporte` WHERE token = ? AND usuario_id = ?");
		$informacao->execute(array($token,$_SESSION['id']));
		$informacao = $informacao->fetch();

		$suporte = MySql::conexaobd()->prepare("SELECT * FROM (SELECT * FROM `comunicacao_suporte` WHERE token_usuario = ? ORDER BY id DESC LIMIT 4) as `comunicacao_suporte` ORDER BY id ASC");
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
			<h3><i class="far fa-comment-dots"></i></h3>
			<h2>Últimas conversas</h2>
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
		<div class="paragrafo-suporte">
			<p>Para ver o histórico da conversa, clique no botão abaixo!</p>
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>historico-conversa?token=<?php echo $token; ?>">Ver toda a conversa</a>
		</div>
		<div class="pergunta">
			<p>Comentários recentes</p>
		</div>
			<?php
				foreach ($suporte as $key => $value){
					if($value['identificacao_usuario'] == -1){
			?>
		<div class="suporte">
			<p><b>Eu:</b> <?php echo ucfirst($value['resposta']); ?></p>
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
			<?php
				$interacoes = MySql::conexaobd()->prepare("SELECT * FROM `comunicacao_suporte` WHERE token_usuario = ? ORDER BY id DESC");
				$interacoes->execute(array($token));

				if($interacoes->rowCount() == 0){
			?>
		<div class="resposta">
			<p>Pergunta esperando resposta...</p>	
		</div>
			<?php
				}else{
					$interacoes = $interacoes->fetch();

					if($informacao['status_andamento'] == 0){
			?>
		<div class="resposta">
			<p>Tópico encerrado</p>	
		</div>
			<?php
					}else{

						if($interacoes['identificacao_usuario'] == -1){
			?>
		<div class="resposta">
			<p>Pergunta esperando resposta...</p>	
		</div>
			<?php
						}else{
			?>
		<div class="painel-info">
			<form method="post">
				<?php
					if(isset($_POST['acao'])){
						$conteudo = $_POST['conteudo'];

						if($conteudo == ''){
							Metodos::mensagem('erro','Campo vazio!');
						}else{
							$admin = -1;
							$sql = MySql::conexaobd()->prepare("INSERT INTO `comunicacao_suporte` VALUES(null,?,?,?)");
							$sql->execute(array($token,$conteudo,$admin));
							Metodos::redirecionamentoEspecifico(INCLUDE_PATH_PAINEL.'comunicacao_suporte?token='.$token);
						}
					}
				?>
				<div>
					<p>Se ainda tiver dúvidas, mande uma mensagem</p>
					<textarea name="conteudo"><?php echo Metodos::recuperarcampopreenchido('conteudo'); ?></textarea>
				</div>
				<div>
					<input type="submit" name="acao" value="Responder">
				</div>
			</form>
		</div>
		<?php
					}
				}
			}
		?>
	</div>
</section>