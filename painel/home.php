<?php
	if(isset($_GET['signout'])){
		Metodos::signout();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" type="text/css" href="<?php echo INCLUDE_PATH_PAINEL; ?>css/style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
	<meta name="keywords" content="palavras-chave,do,meu,site">
	<meta name="description" content="Descrição do meu website">
	<title>Painel Administrativo</title>
</head>
<body>
	<base base="<?php echo INCLUDE_PATH_PAINEL; ?>"></base>
	<div>
		<aside>
			<div class="informacoes-usuario">
				<?php
					if($_SESSION['foto_usuario'] !== '0'){
				?>
				<div class="foto-usuario">
					<div style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>imagens/usuarios/<?php echo $_SESSION['foto_usuario']; ?>');"></div>
				</div>
				<?php
					}else{
				?>
				<div class="sem-foto-usuario">
					<div>
						<h3><i class="fas fa-user"></i></h3>
					</div>
				</div>
				<?php
					}
				?>
				<div class="credenciais-usuario">
					<p><?php echo ucfirst($_SESSION['nome']); ?></p>
					<p><?php echo Metodos::$tipousuario[$_SESSION['tipousuario']]; ?></p>
				</div>
				<div class="clear"></div>
			</div>

			<div class="opcoes-menu">
				<ul>
					<li class="pagina-inicial-menu2">
						<div>
							<a href="<?php echo INCLUDE_PATH; ?>">Página inicial</a>
						</div>
					</li>

					<li class="pagina-inicial-menu3">
						<div>
							<a title="Página inicial - Painel" href="<?php echo INCLUDE_PATH_PAINEL; ?>">
								<h3><i class="fas fa-home"></i></h3>
								<p>Home - Painel</p>
							</a>
						</div>
					</li>

					<li id="drop-down">
						<div>
							<h2>Dados da conta</h2>
							<h3><i class="fas fa-plus-circle"></i></h3>
						</div>
						<div>
							<div <?php echo destaque('editar-dados')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>editar-dados">
									<h3><i class="fas fa-user-edit"></i></h3>
									<p>Editar dados</p>
								</a>
							</div>
						</div>
					</li>

					<li <?php echo verificacaoPermissao(2); ?> id="drop-down">
						<div>
							<h2>Site</h2>
							<h3><i class="fas fa-plus-circle"></i></h3>
						</div>
						<div>
							<div <?php echo destaque('adicionar-banners')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-banners">
									<h3><i class="fas fa-image"></i></h3>
									<p>Adicionar banners</p>
								</a>
							</div>
							<div <?php echo destaque('lista-banners')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-banners">
									<h3><i class="fas fa-images"></i></h3>
									<p>Listagem de banners</p>
								</a>
							</div>
							<div <?php echo destaque('adicionar-avaliacoes')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-avaliacoes">
									<h3><i class="fas fa-pen-square"></i></h3>
									<p>Adicionar avaliações</p>
								</a>
							</div>
							<div <?php echo destaque('lista-avaliacoes')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-avaliacoes">
									<h3><i class="fas fa-list-alt"></i></h3>
									<p>Listagem de avaliações</p>
								</a>
							</div>
						</div>
					</li>

					<li <?php echo verificacaoPermissao(2); ?> id="drop-down">
						<div>
							<h2>Usuários</h2>
							<h3><i class="fas fa-plus-circle"></i></h3>
						</div>
						<div>
							<div <?php echo destaque('adicionar-usuario')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-usuario">
									<h3><i class="fas fa-user-plus"></i></h3>
									<p>Adicionar usuários</p>
								</a>
							</div>
							<div <?php echo destaque('lista-usuarios')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-usuarios">
									<h3><i class="fas fa-user"></i></h3>
									<p>Listagem de usuários</p>
								</a>
							</div>
						</div>
					</li>

					<li <?php echo verificacaoPermissao(0); ?> id="drop-down">
						<div>
							<h2>Contato - Suporte</h2>
							<h3><i class="fas fa-plus-circle"></i></h3>
						</div>
						<div>
							<div <?php echo destaque('suporte')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>suporte">
									<h3><i class="fas fa-comments"></i></h3>
									<p>Enviar mensagem</p>
								</a>
							</div>
							<div <?php echo destaque('mensagens-suporte')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>mensagens-suporte">
									<h3><i class="fas fa-comment-lines"></i></h3>
									<p>Mensagens enviadas</p>
								</a>
							</div>
						</div>
					</li>

					<li <?php echo verificacaoPermissao(1,2); ?> id="drop-down">
						<div>
							<h2>Suporte</h2>
							<h3><i class="fas fa-plus-circle"></i></h3>
						</div>
						<div>
							<div <?php echo destaque('resposta-suporte')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>resposta-suporte">
									<h3><i class="fas fa-comment-edit"></i></h3>
									<p>Responder mensagens</p>
								</a>
							</div>
							<div <?php echo destaque('denuncias')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>denuncias">
									<h3><i class="fas fa-flag"></i></h3>
									<p>Ver denuncias</p>
								</a>
							</div>
						</div>
					</li>

					<li <?php echo verificacaoPermissao(1,2); ?> id="drop-down">
						<div>
							<h2>Blog</h2>
							<h3><i class="fas fa-plus-circle"></i></h3>
						</div>
						<div>
							<div <?php echo destaque('adicionar-categorias')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-categorias">
									<h3><i class="fas fa-pen"></i></h3>
									<p>Adicionar categorias</p>
								</a>
							</div>
							<div <?php echo destaque('lista-categorias')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-categorias">
									<h3><i class="fas fa-th-list"></i></h3>
									<p>Listagem de categorias</p>
								</a>
							</div>
							<div <?php echo destaque('adicionar-noticias')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>adicionar-noticias">
									<h3><i class="fas fa-newspaper"></i></h3>
									<p>Adicionar notícias</p>
								</a>
							</div>
							<div <?php echo destaque('lista-noticias')?>>
								<a href="<?php echo INCLUDE_PATH_PAINEL; ?>lista-noticias">
									<h3><i class="fas fa-clipboard-list"></i></h3>
									<p>Notícias cadastradas</p>
								</a>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</aside>
	</div>

	<header>
		<div class="menu-painel">
			<h3><i class="fas fa-bars"></i></h3>
		</div>
		<div class="logout">
			<a href="<?php echo INCLUDE_PATH_PAINEL; ?>?signout">Sair</a>
		</div>
		<div class="pagina-inicial-menu">
			<a href="<?php echo INCLUDE_PATH; ?>">Página inicial</a>
		</div>
		<div class="clear"></div>
	</header>

	<div class="php">
		<?php
			Metodos::carregarpagina();
		?>
	</div>

	<div class="fundo-transparente"></div>
	
	<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL; ?>javascript/jquery.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL; ?>javascript/jquery.ajaxform.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL; ?>javascript/arquivo.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL; ?>javascript/constantes.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL; ?>javascript/scripts.js"></script>
	<script type="text/javascript" src="<?php echo INCLUDE_PATH_PAINEL; ?>javascript/busca.js"></script>
</body>
</html>