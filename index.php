<?php

		@include("./connect.php");
		
		session_start();
		
		@include("./CSRF.secure.class.php");

		 OpenConnect();

	date_default_timezone_set('America/Sao_Paulo');

	$http_client_ip       = $_SERVER['HTTP_CLIENT_IP'];
	$http_x_forwarded_for = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote_addr          = $_SERVER['REMOTE_ADDR'];
	 
	if(!empty($http_client_ip)){
	    $IP = $http_client_ip;
	} elseif(!empty($http_x_forwarded_for)){
	    $IP = $http_x_forwarded_for;
	} else {
	    $IP = $remote_addr;
	}



function cod($tamanho = 5, $maiusculas = true, $numeros = true, $simbolos = false) {
	// $lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	// $simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	// $caracteres .= $lmin;
	
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;

$len = strlen($caracteres);

for ($n = 1; $n <= $tamanho; $n++) {

$rand = mt_rand(1, $len);
$retorno .= $caracteres[$rand-1];
}
return $retorno;
}

// TOKEN
$csrf = new csrf();
 
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);
 
$form_names = $csrf->form_names(array('cod'), false);
 
if(isset($_POST[$form_names['cod']])){
        if($csrf->check_valid('post')){
            $c0d = addslashes($_POST[$form_names['cod']]);
        }
        $form_names = $csrf->form_names(array('cod'), true);
}

// ./End TOKEN

?>

<!-- // 

* DEVELOPED BY: JONAS A. CONTACT -> twitter.com/JoonaasHD *

// -->

<!DOCTYPE html>
	<html lang="pt-br">
	    <head>

			<meta charset="UTF-8">

			<title>.: GET IP :. GET PEOPLE ANY IP!</title>
			
			<link rel="stylesheet" type="text/css" href="./main.css">
			<link rel="shortcut icon" type="favicon" href="./favicon.png">

			<meta name="viewport" content="minimal-ui, width=device-width, initial-scale=0.2, maximum-scale=0.65">

		</head>
		<body>

<section>

<div class="area-logar">
	
<?php

if((!isset ($_SESSION['usuario']) == true) and (!isset ($_SESSION['password']) == true))
{
	unset($_SESSION['usuario']);
	unset($_SESSION['password']);
	}
	
session_regenerate_id();
$usr = $_SESSION['usuario'];

if(isset($usr)){
	$log   = '<a href="./logout">Sair</a>';
	$his   = '<a href="./achieved" style="text-decoration:none;"> ~ ver meu histórico</a>';
	$fi    = '';
	$user2 = $usr;
} else {
	$usr = "visitante";
	$log = '<a href="./login">LOGIN</a>';
	$his = "";
	$fi  = 'Caso você queira salvar seus códigos,<br/> <a href="./register">crie uma conta</a>, ou <a href="./login">logue-se</a>.'; 
	$user2 = $usr;
}
?>


	<span>Olá <b><?php echo $usr; ?></b> <?php echo $log; ?> </span>

</div>


<div class="area-link">

<h3>DIGITE A URL E MANDE O LINK</h3>

<form action="" method="POST">
	<input type="url" name="url" placeholder="Ex: https://google.com" required="required"></input>
	<input type="hidden" name="code" value="<?php echo $senha = cod(5, true, true); ?>">
	<input type="submit" name="link" value="PRONTO"></input>
</form>

</div>


<div class="area-code">

<h3>JÁ TEM O CÓDIGO?</h3>
<form action="" method="POST">
	<input type="text" placeholder="Ex: R1J93" name="cod" required="required"  pattern="[^'\x22]+"></input>
	<input type="submit" name="coder" value="CHECK"></input>
	<input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
</form>

 
</div>
<?php

/*
$str = "abdte";
$codigo = str_shuffle($str);

echo $codigo;
 
*/
 
// $sql = $mysqli->query("SELECT url FROM redirect WHERE url='$url' ");
// if($sql->num_rows == true){
// echo "Código ok"
// }


if(isset($_POST['coder'])){

$CODDEN = addslashes($_POST['cod']);



$sql = $mysqli->query("SELECT url, cod FROM redirect WHERE cod='$CODDEN'");

if($sql->num_rows == true){

	$exibe = mysqli_fetch_array($sql);

	$END = $exibe["url"];

	echo '<div class="ok">ESSE CÓDIGO CORRESPONDE A ESSA URL: <a href="'.$END.'" target="_blank">'.$END.'</a> </div>';

} else {
	
echo '<div class="failed">Desculpe-me mas este código não corresponde a nenhuma url.</div>';


} // if sql num rows

} // do if isset


// <!-- :: -->

// faz o redirect através do ?c=CODE

   if(isset($_GET['c'])){

    $c = addslashes($_GET['c']);

	$q = $mysqli->query("SELECT url, cod FROM redirect WHERE cod='$c'");

	if($q->num_rows == true){

		$user    = $user2;
		$data    = date('H:i:s d-m-Y');
		$_codigo = $c;

	$exibe = mysqli_fetch_array($q);

	$END = $exibe["url"];

	$mysqli->query("INSERT INTO ips_achieved (ip, usuario, data, link, code) VALUES ('$IP', '$user','$data','$END','$_codigo')");


header('Location: '.$END.'');
    



}
else {

	header("Location: ./error-codigo");
} 
}

// } // if sql num rows

if(isset($_POST['link'])){

	if(empty($_POST['url'])){
		header('Location: ./');
	}

	if(empty($_POST['code'])){
		header('Location: ./');
	}

	$url  = addslashes($_POST['url']);
	$code = addslashes($_POST['code']);

} else {

	echo '<div class="info">Insira uma url válida para encurtar e pegar o IP. Ao clicar em PRONTO,<br/> você concorda com os <a href="./termos" style="text-decoration:none;">termos.</a> '.$fi.' '.$his.' </div> <br/> <span>Seu IP: '.$IP.' <br/> </span>  </body>  </html>';
	return false;
}


$sql = $mysqli->query("SELECT cod FROM redirect WHERE cod='$code'");

if($sql->num_rows == true){
	echo '<div class="failed">Não foi possível encurtar o link.</div>';
	return true;

} else {
	

	if($mysqli->query("INSERT INTO  redirect (url, cod) VALUES ('$url', '$code')")){

    	echo '<br/> <b class="success">Success</b> <br/> <br/>';
    	echo '<div class="url">ENVIE ESSA URL: <a href="http://goit.pe.hu/?c='.$code.'" target="_blank">http://goit.pe.hu/?c='.$code.'</a></div>';

	} else {

		echo '<b style="color:red;">Error</b>';
	
	}

} // if sql num rows

?>

<?php
 $mysqli->close();
?>

</section>
</body>
</html>