<?php

	@include("./connect.php");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Registrar-se</title>

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
    <label class="control-label" for="inputEmail">Seu nome *</label>
    <div class="controls">
      <input type="text" id="inputEmail" name="nome" placeholder="Seu nome">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputEmail">Usuário *</label>
    <div class="controls">
      <input type="text" id="inputEmail" name="usuario" placeholder="Usuário">
    </div>
  </div>

    <div class="control-group">
    <label class="control-label" for="inputEmail">E-mail *</label>
    <div class="controls">
      <input type="email" id="inputEmail" name="email" placeholder="E-mail">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="inputPassword">Senha *</label>
    <div class="controls">
      <input type="password" name="password" id="inputPassword" placeholder="Senha">
    </div>
  </div>

    <div class="control-group">
    <label class="control-label" for="inputPassword">Reescreva a Senha *</label>
    <div class="controls">
      <input type="password" name="password2" id="inputPassword" placeholder="A Senha novamente">
    </div>
  </div>

  <div class="control-group">
    <div class="controls">

      <button type="submit" name="registrar" class="btn">Cadastrar</button>
    </div>
  </div>
</form>

<a href="login">Já cadastrado? - Logue-se</a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="./lib/js/bootstrap.min.js"></script>
    <script src="./lib/js/bootstrap.js"></script>
 

</body>

<?php 


if(isset($_POST['registrar'])){

  $nome    = addslashes($_POST['nome']); 
	$usuario = addslashes($_POST['usuario']);
	$senha   = addslashes($_POST['password']);
  $senha2  = addslashes($_POST['password2']);
  $email   = addslashes($_POST['email']);

	if($usuario == "" || $senha == "" || $senha2 == "" || $email == ""){
		
    echo "<br/> Escreva todos os campos.";
    return false;

}
  if($senha != $senha2){
  
  echo "<br/> As senhas devem ser iguais.";
		return false;
}

  OpenConnect();

// examina se já existe o usuario

  $w = $mysqli->query("SELECT usuario FROM usuarios WHERE usuario='$usuario'");

  if($w->num_rows == true){

  $exibe = mysqli_fetch_array($w);

    echo "<br/> Este usuário já existe.";

    return false;

  }

  // olha se existe o email já criado

    $i = $mysqli->query("SELECT usuario FROM usuarios WHERE email='$email'");

  if($i->num_rows == true){

  $exibe = mysqli_fetch_array($i);

    echo "<br/> Este email já está cadastrado, tente outro.";

    return false;

  }

 if($mysqli->query("INSERT INTO usuarios (nome, usuario, password, email) VALUES ('$nome', '$usuario', '".base64_encode(md5(sha1(md5(sha1($senha)))))."', '$email')")){

    header("Location: ./login");

    } else {

    echo "<br/> Não foi possível te cadastrar. :(";
   
    }
} 
	
?>
</html>