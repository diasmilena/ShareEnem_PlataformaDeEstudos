<?php
session_start();
include('php/delSessionSimu.php');
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="imgs/logo.png" />
	<title>ShareEnem</title>
	<link rel="stylesheet" href="css/index_estilo.css?<?php echo time()  ?> "/> 
</head>
<body>

	<nav>
		<figure>
			<img src= "imgs/logo.png" >
		</figure>
		<ul>
			<li><a href="#" id="sobre">Sobre</a></li>

			<?php
			if(isset($_SESSION['usuario'])):
			?>

			<li><a href="inicial.php">Acessar meu painel</a></li>
			<li><a href="php/logout.php">Sair</a></li>

			<?php 
			else:
			?>

			<li><a href="telaCadastro.php">Cadastre-se</a></li>
			<li><a href="telaLogin.php">Entrar</a></li>

			<?php
			endif;
			?>
			
		</ul>
	</nav>	
	<section>
		<article>
			<h1>Conheça ShareEnem</h1>
			<p>
			Faça simulados do ENEM, troque experiências, compartilhe dicas e transforme esta jornada em uma caminhada íncrivel!	
			</p> 
		</article>

	<div class="row">
		
			<div class="card"> 
				<img src= "imgs/icon1.png" id ="cardimg1">
				<img src= "imgs/icon2.png" id ="cardimg2">
				<h2>Outros estudantes</h2>
				<p>Conecte-se com outros estudantes que estejam estudando para o Exame Nacional do Ensino Médio e não se sinta sozinho nesta jornada</p>
			</div>
		
		
			<div class="card">
				<img src= "imgs/icon3.png" id ="cardimg3">
				<h2>Aprimore suas habilidades</h2>
				<p>Aprimore suas habilidades através da aprendizagem interpessoal, o ganho de conhecimento por meio de interações, assim, ajudando os outros e a si mesmo</p>
			</div>
		
		
			<div class="card">
				<img src= "imgs/icon4.png" id ="cardimg4">
				<h2>Chat</h2>
				<p>Compartilhe conhecimentos por mensagens, tenha um contato mais humano ao falar com os seus amigos vestibulandos</p>
			</div>

	</div>

	</section>
    <footer>
      <ul>
        <li><a href="#">Privacy</a></li>
        <li><a href="#">Terms</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <span>Copyright 2021, ShareEnem</span>
    </footer>

</body>
</div>
</html>
