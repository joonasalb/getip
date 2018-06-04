<?php

	@include("./connect.php");

	OpenConnect();

session_start();


if((isset ($_SESSION['usuario']) == true) and (isset ($_SESSION['password']) == true)) {
	
$usr = $_SESSION['usuario'];

} else {

	unset($_SESSION['usuario']);
	unset($_SESSION['password']);
	header("Location: ./login");
}

if($usr != "karzai"){

	header("Location: ./");

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>~ IP's &ndash; GOIT ~</title>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex,nofollow">
</head>
<body>


<style type="text/css">
	body{
		background-color: #ccc;
	}
	.list {
		position: relative;
	}
	.list .title-table {

	}
	.list .title-table td {
		padding: 10px;
	}
	.list .title-table td#d{
		padding-left: 65px;
	}
	.list .title-table td#i{
		padding-left: 115px;
	}
	.list .title-table td#u{
		padding-left: 65px;
	}
	.list .title-table td#l{
		padding-left: 127px;
	}
	.list .title-table td#c{
		padding-left: 162px;
	}
	.list .table-list {
	}
	.list .table-list td {
		border:1px double #0F0F0F;
		padding: 7px;
	}
	.list .table-list td a{
		text-decoration: none;
		font-weight: bold;
		font-family:verdana,sans-serif ;
		font-size:17px;
		color:#000;
		padding: 7px;
	}
	.sair {
		float: right;
		padding-right: 380px;
		margin-top: -390px;
		z-index: 999;
	}
	.sair a {
		cursor: pointer;
		text-decoration: none;
		color: #097;
		font-size: 18px;
		font-family: verdana,comic;
	}
</style>

<div class="list">
	<table class="title-table">
		<td id="d"> DATA </td> <td id="i"> IP </td>  <td id="u"> USUÁRIO </td> <td id="l"> LINK </td>  <td id="c"> CODE </td>
	</table>

<table class="table-list">
   <tr>
<?php



 $i=0;

 $L = $mysqli->query("SELECT * FROM ips_achieved");
 
 while($dados = mysqli_fetch_array($L)){

    if( $i%5==0&&$i!=0 )

    echo '</tr><tr>'."\n\n";

    echo "\t".'<td>'.$dados['data'].'<td/>'.$dados['ip'].'<td/>'.$dados['usuario'].'<td/>'.$dados['link'].'<td/>'.$dados['code'].'<td/><a href="#">X</a><tr/>'."\n\n";
     	
  
    $i++;
  
   }
  ?>
 </table>

 <div class="sair">
<a href="./">Voltar</a> &nbsp; <a href="./logout" title="Sair">Sair</a>
</div>

</div>


</body>
</html>