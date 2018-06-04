<?php
	
	function OpenConnect(){
		global $mysqli;

		$host  = "localhost";
		$user  = "root"; // u676408309_opaco
		$pwd   = "";
		$banco = "getip"; //u676408309_getip

		$mysqli = new mysqli($host,$user,$pwd,$banco);
		if($mysqli->connect_error){
			
			printf ("Error na conexão. Desculpe! %s", $mysqli->connect_error);
		}
	}
?>