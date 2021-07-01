<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShareEnem - Login</title>
    <link rel="shortcut icon" href="imgs/logo.png" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/login_cadastro_estilo.css">
</head>
<body>
    <div id="content" class="conteudo">
    <a href="index.php" class="fas fa-chevron-left"></a>
        <form id="formulario_login" class="formulario">
            <h1>Entre</h1>

                <div class="div_erro">
                    <p id="msg_erro">Email ou senha incorretos</p>
                </div>
             
            <label for="email-label" id="email-label">E-mail</label>
            <input type="email" name="email" id="email" placeholder="Digite seu email" required />

            <label for="senha-label" id="senha-label" required>Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required/>

            <button type="submit" id="button_logar">Fazer login</button>  
        </form>

        <p class="cadastre_se">Ainda não é cadastrado? <a href="telaCadastro.php">Cadastre-se</a></p>

    </div>  

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?"></script> 
    <script src="js/index.js"></script>
</body>
</html>
