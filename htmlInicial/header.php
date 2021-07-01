<header>

<nav id="nav">

	<ul>
		<div class="itens-nav" >			
			<li> <i class="far fa-comments" onclick="openNav()"></i></li>
		</div>

		<div class="itens-nav">	

			<li>
				<form id="forms_search">
					<button  type="button" id="btnVoltar"><i class="fas fa-arrow-left" id="voltar"></i></button>
					<input type="text" name="txtPesquisa" id="txtPesquisa" placeholder="Pesquise nome/descrição" title = "pesquise um simulado pelo seu nome ou descrição" required>
					<button  type="submit" id="btnPesquisar"><i class="fas fa-search"></i></button>
				</form>
			</li>
			<li id="opcoes_perfil" class="wrapper">
			<?php
			echo' <img src= "data:image/jpeg;base64,'.base64_encode($_SESSION['foto']).'"" id="perfil" id_usuario= "'.$_SESSION['usuario_id'].'" id_conexao = ""  funcao = "'.$_SESSION['funcao'].'" >';
			?>

			<div class="content" class="aparecer" id="popover">
				<?php echo' <p> '.$_SESSION['usuario'].'</p>'; ?>
				<button id="meuPerfil">Meu perfil </button>
				<button><a href="php/logout.php"><i class="fas fa-sign-out-alt"></i> Sair</a></button>
			</div>

			</li>	
		</div>
	</ul>
</nav>

<div class="progress">
  <span class="progress-bar"></span>
</div>

</header>

<!-- o negócio dos contatos do lado-->
<div id="mySidenav" class="sidenav">

		<h3>Chats</h3>   <p href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</p>
		<div id="chats">

		</div>
</div>	

<!-- CHAT -->
<div class="conversa">
	<div id="fecharConversa">&times;</div>

	<div class = "infoContato" idUsuario = "" idConexaoContAtual = "" idChat = "">
		<img class ="fotousuario" src= "  "> <p class ="nomeusuario">  </p>
	</div>

	<div id = "boxMsgs">

	</div>
	<div id="boxEnviarMsg"><input type="text" name="mensagem" id="inputMsg"/> <button id="btnEnviarMsg"><i class="fas fa-paper-plane"></i></button></div>

</div>
	

<!-- JANELA MODAL PERFIL -->
<div class="maskPerfil">
	<div class="boxPerfil">
	<div class="fecharPerfil">X</div>

	<i class="fas fa-user-edit" id="btnEditPerfil"></i>

	<img id="usuFoto" class ="infos" src="imgs_inicial/fotousuario.png">

	<label>Nome Completo</label>
	<h3 id="usuNome" class ="infos" ></h3>
	<label>Nome usuário</label>
	<h4 id="usuNomeDeUsu" class ="infos" ></h4>
	<label>Descrição perfil</label>
	<p id="usuDescricao" class ="infos" ></p>

	<span id="usuDataCadastro" class ="infos" title="data de cadastro"></span>
		
	</div>
</div>

<!-- JANELA MODAL UPDATE PERFIL -->

<div class="maskPerfilEdit">
<div class="boxPerfilEdit"> 
        <form class = "formPerfilEdit">
          <div class="fecharPerfilEdit">X</div>

           <div id="div-foto">

           		<figure>
           			<img src="data:image/jpeg;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=" id="imgFoto"/>
           			<i class="fas fa-camera" id="labelFoto"></i>
				</figure>

            	<input type="file" id="fileFoto"> <!-- esta como display none pra eu consegui estilizar como eu quiser-->

            	<input type="hidden" name="txtFoto" id="txtFoto"/> 

            </div>

            <p>Nome Completo</p>
            <input type="text" name="txtNomeCompleto" id="txtNomeCompleto" placeholder="Digite seu nome completo" required/>

            <p>Nome usuário</p>
            <input type="text" name="txtNomeUsuario" id="txtNomeUsuario" placeholder="Digite seu nome de usuário" required/>

            <p>Descrição perfil</p>
            <textarea  name="txtDescricao" id="txtDescricao" placeholder="Descreva um pouco sobre você"></textarea>
            
            <input type="submit" id="btnEnviarEditPerfil" value="Salvar alterações">
        </form>
</div>
</div>
