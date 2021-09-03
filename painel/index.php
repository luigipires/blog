<?php
	ini_set('max_execution_time','0');
	ini_set('memory_limit','-1');

	include('../config.php');

	if(Metodos::login() == false){
		Metodos::redirecionamentoespecifico(INCLUDE_PATH);
	}else{
		include('home.php');
	}
?>