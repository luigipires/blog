<?php
	$url = explode('/',$_GET['url']);

	if(!isset($url[2])){
		$puxarcategoria = MySql::conexaobd()->prepare("SELECT * FROM `categorias_noticia` WHERE url = ?");
		$puxarcategoria->execute(array(@$url[1]));
		$puxarcategoria = $puxarcategoria->fetch();
?>
<section>
	<div class="header-noticia">
		<h3><i class="fas fa-info-circle"></i></h3>
		<h2>Acesse as informações abaixo</h2>
	</div><!-- header-noticia -->

	<div class="noticias">
		<div class="side-noticia">
			<div>
				<h2>O que você procura?</h2>
				<form method="post">
					<div>
						<h3><i class="fas fa-search"></i></h3>
						<input type="text" name="busca" placeholder="pesquisar">
					</div>
					<div>
						<input type="submit" name="acao-busca" value="Pesquisar">
					</div>
				</form>
			</div>

			<div>
				<h2>Selecione a categoria</h2>
				<select name="categoria">
					<option value="" selected="">Todas as categorias</option>
					<?php
						$categoria = MySql::conexaobd()->prepare("SELECT * FROM `categorias_noticia` ORDER BY nome_categoria ASC");
						$categoria->execute();
						$categoria = $categoria->fetchAll();

						foreach ($categoria as $key => $value){
					?>
					<option <?php if($value['url'] == @$url[1]) echo 'selected'; ?> value="<?php echo $value['url']; ?>"><?php echo ucfirst($value['nome_categoria']); ?></option>
					<?php
						}
					?>
				</select>
			</div>
		</div><!-- side-noticia -->

		<div class="content-noticia">
			<div class="noticia-single">
				<div class="titulo-noticia">
					<?php
						$cadapagina = 6;

						if(!isset($_POST['busca'])){
							if(!isset($puxarcategoria['nome_categoria'])){
								echo '<h2>Visualizando todas as notícias</h2>';
							}else{
								echo '<h2>Visualizando todas as notícias de <b>'.$puxarcategoria['nome_categoria'].'</b></h2>';
							}
						}else{
							if($_POST['busca'] == ''){
								echo '<h2>Visualizando todas as notícias</h2>';
							}else{
								echo '<h2>Mostrando resultados de <b>'.$_POST['busca'].'</b></h2>';
							}
						}

						$query = "SELECT * FROM `noticias` ";

						if(isset($puxarcategoria['nome_categoria'])){
							$puxarcategoria['id'] = (int)$puxarcategoria['id'];
							$query.="WHERE categoria_id = $puxarcategoria[id]";
						}

						if(isset($_POST['busca'])){
							if(strstr($query,'WHERE') !== false){
								$busca = $_POST['busca'];
								$query.=" AND titulo LIKE '%$busca%'";
							}else{
								$busca = $_POST['busca'];
								$query.=" WHERE titulo LIKE '%$busca%'";
							}
						}

						/********************paginação********************/

						$query2 = "SELECT * FROM `noticias` ";

						if(isset($puxarcategoria['nome_categoria'])){
							$puxarcategoria['id'] = (int)$puxarcategoria['id'];
							$query2.="WHERE categoria_id = $puxarcategoria[id]";
						}

						if(isset($_POST['busca'])){
							if(strstr($query2,'WHERE') !== false){
								$busca = $_POST['busca'];
								$query2.=" AND titulo LIKE '%$busca%' ";
							}else{
								$busca = $_POST['busca'];
								$query2.=" WHERE titulo LIKE '%$busca%' ";
							}
						}

						$totalpaginas = MySql::conexaobd()->prepare($query2);
						$totalpaginas->execute();
						$totalpaginas = ceil($totalpaginas->rowCount() / $cadapagina);

						/****************************************************/

						if(!isset($_POST['busca'])){
							if(isset($_GET['pagina'])){
								$pagina = (int)$_GET['pagina'];

								if($pagina > $totalpaginas){
									$pagina = 1;
								}

								$querypagina = ($pagina - 1) * $cadapagina;
								$query.=" ORDER BY titulo LIMIT $querypagina,$cadapagina";
							}else{
								$pagina = 1;
								$query.=" ORDER BY titulo LIMIT 0,$cadapagina";
							}
						}else{
							$query.=" ORDER BY titulo ASC";
						}

						$sql = MySql::conexaobd()->prepare($query);
						$sql->execute();
						$sql = $sql->fetchAll();
					?>
				</div><!-- titulo-noticia -->
				<?php
					foreach ($sql as $key => $value){
						$nomecategoria = MySql::conexaobd()->prepare("SELECT * FROM `categorias_noticia` WHERE id = ?");
						$nomecategoria->execute(array($value['categoria_id']));
						$nomecategoria = $nomecategoria->fetch();
				?>
				<div class="conteudo-noticia">
					<h2><?php echo ucfirst($value['titulo']); ?></h2>
					<div>
						<p><?php echo substr(ucfirst($value['conteudo']),0,300); ?> <b>[...]</b></p>
						<a href="<?php echo INCLUDE_PATH; ?>blog/<?php echo $nomecategoria['url']; ?>/<?php echo $value['url']; ?>">Ler mais</a>
					</div>
				</div><!-- conteudo-noticia -->
				<?php
					}
				?>

				<div class="paginacao">
					<?php
						if(!isset($_POST['busca'])){
							for($i = 1; $i <= $totalpaginas; $i++){
								$categoriapagina = (isset($puxarcategoria['nome_categoria'])) ? '/'.$puxarcategoria['url'] : '';

								if($pagina == $i){
									echo '<a class="selecionado" href="'.INCLUDE_PATH.'blog'.$categoriapagina.'?pagina='.$i.'">'.$i.'</a>';
								}else{
									echo '<a href="'.INCLUDE_PATH.'blog'.$categoriapagina.'?pagina='.$i.'">'.$i.'</a>';
								}
							}
						}
					?>
				</div><!-- paginacao -->
			</div><!-- noticia-single -->
		</div><!-- content-noticia -->
	</div><!-- noticias -->
</section>
<?php
	}else{
		include('noticia.php');
	}
?>