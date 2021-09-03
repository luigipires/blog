<?php
	include('../../config.php');

	if(Metodos::login() == false){
		Metodos::redirecionamentoespecifico(INCLUDE_PATH);
	}

	$data = [];
	$data['sucesso'] = true;
	$data = '';

	if(isset($_POST['informacao']) && isset($_POST['pesquisa-usuarios'])){
		$email = $_POST['informacao'];

		$usuario = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE email LIKE ? AND id != ?");
		$usuario->execute(array("%$email%",$_SESSION['id']));
		$usuario = $usuario->fetchAll();

		$data.='
			<tr class="cabecalho-info">
					<td>Nome</td>
					<td>Cargo</td>
					<td></td>
					<td></td>
				</tr>';

		foreach ($usuario as $key => $value){
			if($value['tipo_usuario'] < $_SESSION['tipousuario']){

			$data.='
				<tr class="tabela-informacoes">
					<td>'.ucfirst($value['nome']).' '.ucfirst($value['sobrenome']).'</td>
					<td>'.Metodos::$tipousuario[$value['tipo_usuario']].'</td>
					<td><a href="'.INCLUDE_PATH_PAINEL.'editar-usuarios?editar='.$value['id'].'">
						<h3><i class="fas fa-edit"></i></h3>
						<p>Editar</p>
					</a></td>
					<td>
						<h3 iduser="'.$value['id'].'" exclusao="excluir" title="Excluir foto"><i class="fas fa-trash-alt"></i>Excluir</h3>
					</td></tr>';
			}
		}
	}

	echo $data;
?>
		