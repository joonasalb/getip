<?php

session_start();

if(isset($_SESSION['usuario']) and isset($_SESSION['password'])){

session_destroy();
session_unset();

header('Location: ./');
exit;
}
else
{
	header('Location: ./');
}

?>