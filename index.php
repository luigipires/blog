<?php
	include('config.php');

	if(isset($_COOKIE['lembrar'])){
		$emailcookie = $_COOKIE['email-login'];
		$senhacookie = $_COOKIE['password-login'];

		$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE email = ? AND senha = MD5(?)");
		$sql->execute(array($emailcookie,$senhacookie));

		if($sql->rowCount() == 1){
			$sql = $sql->fetch();
			$_SESSION['login'] = true;
			$_SESSION['email'] = $sql['email'];
			$_SESSION['id'] = $sql['id'];
			$_SESSION['nome'] = $sql['nome'];
			$_SESSION['sobrenome'] = $sql['sobrenome'];
			$_SESSION['foto_usuario'] = $sql['foto_usuario'];
			$_SESSION['tipousuario'] = $sql['tipo_usuario'];
		}
	}

	if(isset($_GET['signout'])){
		Metodos::signout();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/slick.css">
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH; ?>css/style.css">
	<meta charset="utf-8">
	<title>Sistema de gestão</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
	<meta name="keywords" content="palavras-chave,do,meu,site">
	<meta name="description" content="Descrição do meu website">
</head>
<body>
	<base base="<?php echo INCLUDE_PATH; ?>"></base>
	<?php
		$url = isset($_GET['url']) ? $_GET['url'] : 'home';
	?>
	<header>
		<div class="logo">
			<a title="Mini" href="<?php echo INCLUDE_PATH; ?>">
				<img src="<?php echo INCLUDE_PATH; ?>imagens/logo.png">
			</a>
		</div>
		<nav class="desktop">
			<ul>
				<li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>blog">Blog</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
				<?php
					if(!isset($_SESSION['login'])){
				?>
				<li><p class="abrir-janela">Entrar</p></li>
				<?php 
					}else{ 
				?>
				<li><p class="abrir-janela"><?php echo ucfirst($_SESSION['nome']); ?></p></li>
				<?php
					}
				?>
			</ul>
		</nav>
		<nav class="mobile">
		<h3><i class="fas fa-bars"></i></h3>
			<ul>
				<li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>blog">Blog</a></li>
				<li><a href="<?php echo INCLUDE_PATH; ?>contato">Contato</a></li>
				<?php
					if(!isset($_SESSION['login'])){
				?>
				<li><p class="abrir-janela">Entrar</p></li>
				<?php 
					}else{ 
				?>
				<li><p class="abrir-janela"><?php echo ucfirst($_SESSION['nome']); ?></p></li>
				<?php
					}
				?>
			</ul>
		</nav>
		<div class="clear"></div>
	</header>

	<div class="php">
		<?php
			if(file_exists('paginas/'.$url.'.php')){
				include('paginas/'.$url.'.php');
			}else{
				if($url != 'sobre' || $url != 'contato' || $url != 'login'){
					$newurl = explode('/',$url)[0];

					if($newurl != 'blog'){
						$erro = true;
						include('paginas/erro.php');
					}else{
						include('paginas/blog.php');
					}
				}else{
					include('paginas/home.php');
				}
			}
		?>
	</div>

	<section>
		<div class="tela-login">
			<div class="fundo-transparente">
				<div class="login">
					<div class="fechar-janela">
						<img title="Fechar" src="<?php echo INCLUDE_PATH; ?>imagens/x.png">
					</div>
					<?php
						if(!isset($_SESSION['login'])){
					?>
					<form id="login-formulario" action="<?php echo INCLUDE_PATH; ?>ajax/dados.php" method="post">
						<div>
							<h2>Entre na sua conta</h2>
						</div>
						<div class="form-email">
							<p>E-mail</p>
							<input type="email" name="email-login">
						</div>
						<div style="position: relative;">
							<p>Senha</p>
							<input type="password" name="password-login">
							<div class="mostrar-senha-login">
								<h3><i class="fas fa-eye"></i></h3>
							</div>
						</div>
						<div>
							<input type="hidden" name="acao-login">
							<input type="submit" value="Entrar">
						</div>
						<div class="complemento-login">
							<div>
								<div>
									<input type="checkbox" name="lembrar">
									<p>Lembrar senha</p>
								</div>
								<div>
									<a href="<?php echo INCLUDE_PATH; ?>recuperar-senha">Esqueci senha</a>
								</div>
							</div>
						</div>
					</form>
					<div class="info-login">
						<p>Caso não tenha uma conta, crie uma acessando o <b>botão abaixo</b></p>
						<a href="<?php echo INCLUDE_PATH; ?>cadastro">Cadastre-se</a>
					</div>
					<?php
						}else{
					?>
					<div class="botao-painel">
						<div>
						<a href="<?php echo INCLUDE_PATH_PAINEL; ?>">Voltar para o painel</a>
						<a href="<?php echo INCLUDE_PATH; ?>?signout">Sair</a>
						</div>
					</div>
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</section>

	<footer>
		<div class="footer-one">
			<div class="location">
				<h4>Localização</h4>
				<p>Rua ficticia ficticia, 000</p>
			</div>

			<div class="atendimento">
				<h4>Horário de atendimento</h4>
				<p>De segunda a sexta</p>
				<p>08:00 - 16:00</p>
			</div>

			<div class="social-media">
				<h4>Redes sociais</h4>
				<a href="#"><h3><i class="fab fa-facebook-square"></i></h3></a>
				<a href="#"><h3><i class="fab fa-instagram"></i></h3></a>
				<a href="#"><h3><i class="fab fa-whatsapp"></i></h3></a>
			</div>
		</div>
		
		<div class="footer-two">
			<p>Todos os direitos reservados</p>
		</div>
	</footer>

	<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>javascript/jquery.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>javascript/constantes.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>javascript/jquery.ajaxform.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>javascript/slick.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>javascript/arquivo.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>javascript/formulario.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>javascript/fotos.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH; ?>javascript/script-noticia.js"></script>
	<?php echo Metodos::carregarjavascript(['redefinicao.js'],'recuperar-senha'); ?>
	<?php echo Metodos::carregarjavascript(['redefinicao.js'],'redefinir-senha'); ?>
	<?php echo Metodos::carregarjavascript(['noticia.js'],'blog'); ?>
</body>
</html>