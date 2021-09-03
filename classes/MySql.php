<?php
	class MySql{

		private static $pdo;

		public static function conexaobd(){
			if(self::$pdo == null){
				try{
					self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
					self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				}catch(EXCEPTION $e){
					echo '<h2 style="text-align: center;font-family: arial;font-size: 17px;">Erro!</h2>';
				}
			}

			return self::$pdo;
		}
	}
?>