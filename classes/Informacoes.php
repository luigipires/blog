<?php
	class Informacoes{

		public static function pegarIDusuario($id){
			$sql = MySql::conexaobd()->prepare("SELECT * FROM `usuarios` WHERE id = ?");
			$sql->execute(array($id));
			
			return $sql->fetch();
		}
	}
?>