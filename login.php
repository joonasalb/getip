<?php

	@include("./connect.php");


session_start();

$usr = $_SESSION['usuario'];

if(isset($usr)){

  echo 'Você já esta logado, deseja sair?<br/><br/><a href="./logout" style="text-decoration:none;">Sim</a> &nbsp;&nbsp;&nbsp; <a href="./" style="text-decoration:none;">Não</a>';

  return false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Goit</title>

  <link rel="shortcut icon" type="favicon" href="./favicon.png">

	<link href="lib/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="lib/css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="lib/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
  <link href="lib/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">

</head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<body>


<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
 
      <!-- .btn-navbar é usado como alternador para conteúdo de barra de navegação colapsável -->
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
 
      <!-- Tenha certeza de deixar a marca se você quer que ela seja mostrada -->
      <a class="brand" href="http://goit.pe.hu">GOIT.PE.HU</a>
 
      <!-- Tudo que você queira escondido em 940px ou menos, coloque aqui -->
      <div class="nav-collapse collapse"><span class="label label-warning">BETA</span>
        <!-- .nav, .navbar-search, .navbar-form, etc -->
      </div>
 
    </div>
  </div>
</div>


<form class="form-horizontal" action="" method="POST" name="form-login">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Usuário</label>
    <div class="controls">
      <input type="text" id="inputEmail" name="usuario" placeholder="Usuário">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Senha</label>
    <div class="controls">
      <input type="password" name="password" id="inputPassword" placeholder="Senha">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox"> Lembre-se de mim
      </label>
      <button type="submit" name="entrar" class="btn">Entrar</button>
    </div>
  </div>
</form>

<a href="register">Não cadastrado? - Cadastre-se</a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="./lib/js/bootstrap.min.js"></script>
    <script src="./lib/js/bootstrap.js"></script>
 

</body>

<?php 

if(isset($_POST['entrar'])){

	$usuario = addslashes($_POST['usuario']);
	$senha = addslashes($_POST['password']);

	if($usuario == "" || $senha == ""){
		echo "<br/> Escreva todos os campos.";

		return false;
}

    
    OpenConnect();


	$SQL = $mysqli->query("SELECT usuario FROM usuarios WHERE usuario='$usuario'");

	if($SQL->num_rows == true){

		$SQL2 = $mysqli->query("SELECT usuario FROM usuarios WHERE usuario='$usuario' AND password='".base64_encode(md5(sha1(md5(sha1($senha)))))."'");
		
		if($SQL2->num_rows == true ){

    session_start();

      $_SESSION['usuario']  = $usuario;
      $_SESSION['password'] = $senha;
      
    header("Location: ./");

		} else {

			echo "<br/> Senha incorreta";
		}
	
		} else {
	
			echo "<br/> Usuário não é válido.";
	}

 $mysqli->close();

}

?>
</html>