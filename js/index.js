$(document).ready(function(){
    $("#buttonLogin").click(function(){
        window.location.href = "telaLogin.php";
    });


    $("#formulario_login").submit(function(e) {
    e.preventDefault();
     var serializeDados = $('#formulario_login').serialize();

        $.ajax({
            url: "php/login.php",
            method: 'POST',
            dataType: 'json',
            data: serializeDados,
            success: function(response) {
            console.log("ajax response:"+ response)

            if(response.error == 1){
                console.log("Senha ou Email vazios ou incorretos");

                $('.div_erro').css('display', 'flex');

                $('.div_erro').css('transform', 'scale(1.05)');
                setTimeout(function() {
                $('.div_erro').css('transform', 'scale(1)');
                }, 300)
            }
        
             if(response.sucesso == 1){
                 console.log("Email e senha corretos");
                window.location.replace("inicial.php");
            }
        }, error: function(error){
            alert("Ocorreu um erro: " + error.status + " " + error.statusText)
        }         
 
        });
    });


    $("#formulario_cadastro").submit(function(e) {
        e.preventDefault();

        if($('#senha').val() == $('#senha-verifica').val()){ //senhas iguais

         $('#txtFoto').val($('#imgFoto').attr('src'));

         var serializeDados = $('#formulario_cadastro').serialize();
    
            $.ajax({
                url: "php/cadastro.php",
                method: 'POST',
                dataType: 'json',
                data: serializeDados,
                success: function(response) {
                    console.log("ajax response:"+ response)
    
                if(response.existe == 1){
                    console.log("Email já existe");
    
                    $('#existe').css('display', 'flex');
    
                    $('#existe').css('transform', 'scale(1.05)');

                    setTimeout(function() {
                    $('#existe').css('transform', 'scale(1)');
                    }, 300)
                }else if(response.erro_dados == 1){
                    console.log("Dados preenchidos incorretamente");

                    $('#erro').css('display', 'flex');
    
                    $('#erro').css('transform', 'scale(1.05)');

                    setTimeout(function() {
                    $('#erro').css('transform', 'scale(1)');
                    }, 300)
                }
                
                 if(response.sucesso == 1){
                     console.log("tudo correto, cadastrado");

                    $(".cadastro").css("height","100%")
                    $("#formulario_cadastro").css("display","none")
                    $(".cadastre_se").css("display","none")

                    $("#cadastro_efetuado").css("display","block")

                    
                }
            }, error: function(error){
                alert("Ocorreu um erro: " + error.status + " " + error.statusText)
                }  
                       
            })
        }else{ //senhas diferentes
            console.log("senha diferentes")
            $('#senhas_diferentes').css('display', 'block');
    
            $('#senhas_diferentes').css('transform', 'scale(1.05)');

            setTimeout(function() {
                $('#senhas_diferentes').css('transform', 'scale(1)');
            }, 300)   
        }

     
        });

    $('#labelFoto').on('click', function() {
        $('#fileFoto').trigger('click');
      });

      $("#fileFoto").change(function () { 
        $('#file-name').text(this.value);

        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) { 
                
            $('#imgFoto').attr('src', e.target.result);
            } 
        reader.readAsDataURL(this.files[0]);

        }
    });
  });