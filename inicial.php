<?php
include('php/verifica_login.php');
include('php/delSessionSimu.php');
?>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="imgs/logo.png" />
	<title>ShareEnem - Início</title>
	<link rel="stylesheet" href="css/inicial_estilo.css?<?php echo time()  ?> "/>

	<script src="https://kit.fontawesome.com/1e592b5726.js" crossorigin="anonymous"></script>

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Train+One&display=swap" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">

</head>

<div id="main">
	
<body>
	<?php
		include("htmlInicial/header.php");
	?>

<div class="background">
<div class="blur">
	<section id="secSimuFeitos">
		<div id="HeaderSimuFeitos">
			<h5>Simulados concluídos</h5>	
		</div>
		<div id="simuladosFeitos">

		</div>
	
	</section>
	<section id ="barraCima">
		<h5>Simulados></h5>
		<?php
		if($_SESSION['funcao'] == "administrador"){
			echo '<button id = "insSimulado">+</button>';
		}
		?>
	</section>

	<section id="sec" class ="conteudo">

	</section>
</div> 
</div>
	<?php
	include("htmlInicial/footer.html")
	?>

	<div class="maskSimu"></div>
	 <!-- Janela Modal --> 
	<div class="mask">
	<div id="boxes"> 
		<div class="info">

		<?php
		if($_SESSION['funcao'] == "administrador"){
			echo '<button class="btnAddQuestao">+</button>';
		}
		?>
			<div class="fechar">X</div> 
			<figure class="siglaSimu"></figure>
			<div>
				<h1 class="titulo"></h1>
				<p class= "descricao"></p>
			</div>
		</div>
		<?php 
		echo '<button class="btnFazerSimulado btnFazerSimuladoHover" id_usuario ="'.$_SESSION['usuario_id'].'" id_simulado = "" >Fazer Simulado</button>
		';  
		?>

		<img src="imgs_inicial/taketest.svg" id="animacaoFazerSimu">
		<div class="questoes">

		</div>
		<button class='btnVerQuestoes'>Ver Questões</button>
		<button type ='submit' class='btnInsQuestao' id_simulado = ''>Adicionar Questao</button>
		<div class ='loadingGif2'><img src='imgs_inicial/loading2.gif'></div>

		<button class='btnEnviarEditQuestao'>Editar Questão</button>
		
	</div>
	<div><p></div>
	</div>
   
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/telainicial.js"></script>
</body>
</div>
</html>
