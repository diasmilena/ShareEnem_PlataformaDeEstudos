<?php
include('php/verifica_login.php');

if(!$_SESSION['simuladoAtual'] || !$_SESSION['sigla']){
	header('Location: inicial.php');
}

header('Access-Control-Allow-Origin: *');

?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ShareEnem - Simulado</title>
	<link rel="shortcut icon" href="imgs/logo.png" />
	<link rel="stylesheet" href="css/inicial_estilo.css?<?php echo time()  ?> "/>

	<script src="https://kit.fontawesome.com/1e592b5726.js" crossorigin="anonymous"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Train+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">

</head>
<div id="main">
<body onload="carregarSimulado()">
	
	<?php 
	include("htmlInicial/header.php");
	include("php/conexao.php");
	?>
	<div class="conteudoSimulados">
		<?php
		echo '<div class="info" id="infotl2" idSimulado="'.$_SESSION['simuladoAtual'].'" siglaSimu="'.$_SESSION['sigla'].'" idUsuario ="'.$_SESSION['usuario_id'].'">
		';
		?>
		<a href="inicial.php" title="voltar" class="fas fa-chevron-left"></a>
		<figure id="siglatl2"class="siglaSimu"></figure>
			<div>
				<h1 class="titulo"></h1>
				<p class= "descricao"></p>
			</div>
		</div>
		<div class="questoestl2">
		<form class="formQuestoes">

		</form>
		</div>
		<button id="btnConcluirSimulado" class="btnHoverEffect">Concluir Simulado</button>
	</div>

	<div id="resultado">

	</div>
	<div id="ranking">
	</div>
	<?php
		include("htmlInicial/footer.html")
	?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/telainicial.js"></script>
</body>
</div>
</html>
