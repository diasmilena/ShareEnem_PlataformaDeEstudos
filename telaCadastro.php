<!DOCTYPE html>
<html lang="pt-BR" class="cadastro">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShareEnem - Cadastro</title>
    <link rel="shortcut icon" href="imgs/logo.png"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/login_cadastro_estilo.css">
</head>
<body class ="cadastro">
    <div class="conteudo">
    <a href="index.php" class="fas fa-chevron-left"></a>
        <form enctype="multipart/form-data"  id="formulario_cadastro" class="formulario">
            <h1>Cadastre-se</h1>

             <label for="email-label" id="email-label">E-mail</label>
            <input type="email" name="email" id="email" placeholder="Digite seu email" required/>

            <label for="nomecompleto-label" id="nomecompleto-label">Nome completo</label>
            <input type="text" name="nomecompleto" id="nomecompleto" placeholder="Digite seu nome completo" required />

            <label for="usuario-label" id="usuario-label">Usuario</label>
            <input type="text" name="usuario" id="usuario" placeholder="Digite seu nome de usuário" required/>

            <label for="senha-label" id="senha-label" required>Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" />

            <label for="senha-verifica-label" id="senha-verifica-label" required>Digite sua senha novamente</label>
            <input type="password" name="senha-verifica" id="senha-verifica" placeholder="Digite sua senha" />

            <div id="senhas_diferentes">Senhas diferentes <i class="fas fa-exclamation-triangle"></i></div>

            <div id="div-foto">
                <label id="txtFoto-label">Foto <span>(opcional)</span></label>

              <label for='filefoto' id="labelFoto">Selecionar um arquivo</label>   <!-- quando isto é apertado o click do input file é acionado -->

                <span id='file-name'></span> <!-- para mostrar o nome do arquivo-->

                <input type="file" id="fileFoto"> <!-- esta como display none pra eu consegui estilizar como eu quiser-->

                <img src="data:image/jpeg;base64,R0lGODlhAQABAAAAACwAAAAAAQABAAA=" id="imgFoto"/>

                <input type="hidden" name="txtFoto" id="txtFoto"/> 
            </div>

            <label for="descricaoperfil-label" id="descricaoperfil-label">Descrição perfil <span>(opcional)</span></label>

            <textarea id="descricaoperfil" name="descricaoperfil"   placeholder="Fale um pouco sobre você" ></textarea>

            <div class="div_erro" id="erro">
                    <p id="msg_erro">Dados preenchidos incorretamente</p>
            </div>

                <div class="div_erro" id="existe">
                    <p id="msg_existe">O email escolhido já está cadastrado</p>
            </div>

           <!-- <p >Já é cadastrado? <a href="telaLogin.php">Faça login</a></p> -->

            <button type="submit" id="button_logar">Fazer cadastro</button>  
        </form>
        <p class="cadastre_se">Já é cadastrado? <a href="telaLogin.php">Faça login</a></p>

        <div id="cadastro_efetuado">
            <h2>Cadastro feito com sucesso! Faça login <a href="telaLogin.php">clicando aqui</a></h2> 
        </div>


    </div>  

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?"></script> 
    <script src="js/index.js"></script>
</body>
</html>