  // POPOVER perfil usuário
$("#opcoes_perfil").click(function(){
  $(".content").toggleClass("aparecer");
});

$("#main").click(function(e){
  if(e.target.id != "perfil" ){
    $("#popover").removeClass("aparecer");
  }
})

//DESFOQUE DA IMAGEM DE FUNDO 
$(document).scroll(function(e) {
    if($(window).scrollTop() > 200){
       $(".blur").addClass("on")
    }else{
      $(".blur").removeClass("on")
    }
});

  //INICIAL.PHP CLICKS
$(document).on("click", ".card , .cardSimuConc", function () {
//esse click vale tanto para os simus concluídos, quanto para os n concluidos
  $(this).children(".loadingGif").show()

  $(".card").css("pointer-events", "none")

  $(".questoes").empty();
  var sigla = $(this).attr("titulo")
  var idsimulado = $(this).attr("idsimulado")

  $(".btnFazerSimulado").attr("id_simulado",  idsimulado)

  selectSimulado(idsimulado, sigla)
  mostrarQuestoes(idsimulado)

  //checar sse o simulado já foi feito
  var idUsuario = $("#perfil").attr("id_usuario")

  var promised = checkRegisSimuExiste(idsimulado, idUsuario)

  promised.done(function(response) {
    if(response == "registroTrue"){
      $(".btnFazerSimulado").html("<i class='fas fa-check'></i>Ver Respostas").css({"padding": "5px"})  
    }
  })
})

$(document).on("click", ".btnFazerSimulado", function () {
  var idSimulado = $(this).attr("id_simulado");
  var sigla = $(".siglaSimu").text();

  $.ajax({
    url: 'php/criarSessionSimu.php',
    method: 'POST',
    data:{'idSimulado': idSimulado, 'sigla': sigla},
    success: function(response){
      console.log(response)
      window.location.assign("telaSimulado.php");
    }, error: function(error){
      alert("Ocorreu um erro insRegistroSimulado: " + error.status + " " + error.statusText);
    }
  })
})

$(document).on("click", "#insSimulado", function () {
  $(".maskSimu").load("modalInsSimulado.php");
  abrirJanelaIns()
})

//parte de adicionar simulado, questões e alternativas
$(document).on("submit", "#formInsAltSimu", function (e) {
  e.preventDefault();

  var form = $("#formInsAltSimu").serialize()+ '&simulado=table';;

  $.ajax({
    url: 'php/ins.php',
    method: 'POST',
    data: form,
    error: function(error){
      alert("Ocorreu um erro insRegistroSimulado: " + error.status + " " + error.statusText);
    }
  }).done(function(response) {

    $(".maskSimu").removeClass("mostrarSimu");
    var retorno = response.split("|");

    selectSimulado(retorno[0], retorno[1])

    $(".btnFazerSimulado").attr("id_simulado", retorno[0])

    abrirJanelaModal()

    $(".btnAddQuestao").trigger("click")

    carregarConteudo()
  })
})

$(document).on("click", ".btnAddQuestao", function () {
  $(".questoes").empty();
  $(".questoes").append("<textarea name='txtQuestao' id='txtQuestao' placeholder='Insira o texto da questão' required></textarea><form class='alts'></form><button class='btnAddAlternativa'>+</button><button class='btnRemoverAlternativa'>-</button>")


  $(".btnFazerSimulado").css("display", "none")

  $(".btnVerQuestoes").css("display", "inline-block")
  $(".btnInsQuestao").css("display", "inline-block")
})

$(document).on("click", ".btnVerQuestoes", function () {
  var idSimulado = $(".btnFazerSimulado").attr("id_simulado")
  $(".btnVerQuestoes").css("display", "none")
  $(".btnInsQuestao").css("display", "none")
  $(".btnEnviarEditQuestao").css("display", "none")
  mostrarQuestoes(idSimulado);
})

$(document).on("click", ".btnAddAlternativa", function () {
  $(".alts").append("<div><input type='radio' name='altCerta' class='inputRadio' value='alt'/><input type='text' name='alt' class='inputAlternativas' placeholder='Insira o texto da alternativa'/></div>");
})

$(document).on("click", ".btnRemoverAlternativa", function () {
  $(".alts").children("div:last").remove()
})

//encadeamento de ifs para fazer a verificação dos dados para inserir a questão e alternativas
$(document).on("click", ".btnInsQuestao", function () {

  var altCerta = $(".inputRadio:checked").next().val()

  if($('#txtQuestao').val().length == 0 || !$('#txtQuestao').val().trim()){
    alert("O simulado precisa ter uma questão")
  }else{
    if(typeof(altCerta) == "undefined"){
      alert("Cheque a resposta certa da questão.")
    }else{
      var idsimulado = $(".btnFazerSimulado").attr("id_simulado")
      
      var campoVazio = 0;
      $('.inputAlternativas').each(function(i, item){
        if($(item).val().length == 0 || !$(item).val().trim()){
          campoVazio = 1;
        }
      });

      if(campoVazio == 1){
        alert("Prencha as alternativas em vazio ou remova elas.")
      }else{
        if($(".alts").children().length < 2){
          alert("A questão precisa ter pelo menos 2 alternativas")
        }else{

        $(".loadingGif2").show()
        $(".btnInsQuestao").hide()

        $.ajax({
        url: 'php/ins.php',
        method: 'POST',
        data: {'txtQuestao': $('#txtQuestao').val(), 'idSimulado': idsimulado,'questao': "table"},
        error: function(error){
          alert("Ocorreu um erro insQuestao: " + error.status + " " + error.statusText);
        }
        }).done(function(response) {

          $('.inputAlternativas').each(function(i, item){
            insAlternativas(response, $(item).val(), altCerta);
          });
        })
        }
      }

    }
  }
})

//editar e excluir questões e alternativas
$(document).on("click", ".btnDelQuestao", function () {

  if (confirm("Você realmente deseja apagar essa questão e suas alternativas?")) {
    var idQuestao = $(this).attr("idquestao");
    var idSimulado = $('.btnFazerSimulado').attr("id_simulado");

    $.ajax({
      url: 'php/excQuestao.php',
      method: 'POST',
      data: {'idQuestao': idQuestao},
       success: function(response){
        console.log(response)
        mostrarQuestoes(idSimulado);
        
      }, error: function(error){
        alert("Ocorreu um erro DelQuestao: " + error.status + " " + error.statusText);
      }
    })
  } 
})

$(document).on("click", ".btnEditQuestao", function () {
  var idQuestao = $(this).attr("idquestao");

  var txtQuestao = $(".Q"+idQuestao+" .txtQuestao").text();

  $(".questoes").empty();
  $(".questoes").append("<input type='hidden' id='idQuestao' value = '"+idQuestao+"'>")

  $(".questoes").append("<textarea name='txtQuestao' id='txtQuestaoTxtArea' placeholder='Insira o texto da questão' required></textarea><form class='alts'></form>")

  $("#txtQuestaoTxtArea").val(txtQuestao)

  $(".btnEnviarEditQuestao").show()
  $(".btnFazerSimulado").css("display", "none")
  $(".btnVerQuestoes").show()

     $.ajax({
    url: 'php/selectSimulado.php',
    method: 'POST',
    data:{ 'idQuestao': idQuestao, 'alternativas':"table"},
    success: function(response) {

      var retorno = response.split("||");

      for (var i = 0; i < retorno.length; i++) { 
        
        var splited = retorno[i].split("|")
        
        $(".alts").append("<div><input type='radio' name='altCerta' class='inputRadio' id='inputIdAltCerta_"+splited[1]+"' value='"+splited[1]+"'/><input type='text' name='alt' class='inputAlternativas' id='"+splited[1]+"'/></div>");

        $("#"+splited[1]).val(splited[2])

        var altCerta = splited[3];
      } 

      $("#inputIdAltCerta_"+altCerta).prop("checked", true);

    }
  });

})

$(document).on("click", ".btnEnviarEditQuestao", function () {

  //upadate questão
  var idQuestao = $("#idQuestao").val();
  var txtQuestao = $("#txtQuestaoTxtArea").val();

  var altCerta = $(".inputRadio:checked").attr("value")

  $.ajax({
    url: 'php/editQuestaoAlt.php',
    method: 'POST',
    data: {'idQuestao': idQuestao, 'txtQuestao': txtQuestao, 'idAltCerta': altCerta},
     success: function(response){

      //update alternativas
      $('.inputAlternativas').each(function(i, item){

        var txtAlt = $(item).val();
      
        var idAlt = $(item).attr("id")

       $.ajax({
        url: 'php/editQuestaoAlt.php',
        method: 'POST',
        data:{ 'idAlt': idAlt, 'txtAlt':txtAlt},
        error: function(error){
          alert("Ocorreu um erro update alternativa: " + error.status + " " + error.statusText);
        }
        });
      }); //fim percorrer classe inputAlternativas

      $(".btnVerQuestoes").trigger("click")


     }, error: function(error){
      alert("Ocorreu um erro update questão: " + error.status + " " + error.statusText);
    }
  })


})
  //TELASIMULADO.PHP CLICKS
$(document).on("click", "#btnConcluirSimulado", function () {
  var form = $(".formQuestoes").serialize();
  var  formRespostas = form.split("&");

  // console.log($(".formQuestoes").serializeArray()) 41=5&8=54

  contAjax = 0;
  cont = 0;

  if($(".formQuestoes").serializeArray().length !== $(".formQuestoes p").length){
    alert("Responda todas as questões")
  }else{
    var respostas = serializeFormJSON($(".formQuestoes"));

    for (var i = 0; i < formRespostas.length; i++) { 
      formRespostasSplited = formRespostas[i].split("=")

      mostrarAlternativaCorreta(formRespostasSplited[0], formRespostasSplited[1], formRespostas.length, respostas);  
    }
   mostrarRankingUsuarios()
  }
})
 
window.onbeforeunload = function(){ 
  var form = $(".formQuestoes").serialize()
  if(form.length != 0){
    return 'Os dados do formulário não foram salvos, deseja permanecer nesta página?';
  }
}



//----------------------------------------FUNÇÕES-------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------

/* sidenav */ 
function openNav() {
  $("#mySidenav").css("width","285px")
  $(".conversa").css("margin-left", "290px")
  $(".itens-nav li .far").css("color", "#5d00a4")
}
function closeNav() {
  $("#mySidenav").css("width","0")
  $(".conversa").css("margin-left", "10px")
  $(".itens-nav li .far").css("color", "#5d00a4")
}

// --------------------FUNCÕES TELA INCIAL ------>

$(document).ready(function(){
  $(".progress-bar").css("width", "5%")  
  carregarConteudo();

  var idUsuario = $("#perfil").attr("id_usuario")
  
  var promised = checkRegisSimu(idUsuario) //promised é a var que armazena a requisição ajax que a função traz
  promised.done(function(response){
    $(".progress-bar").css("width", "100%")  
      setTimeout(function(){ 
        $(".progress").hide()
      }, 2000);
      
    if(response == "registroFalse"){
      $("#secSimuFeitos").css("display","none")
      $("#barraCima").css("padding-top","525px")
    }else{
      $("#secSimuFeitos").css("display","block")
      $("#simuladosFeitos").html(response);
    }
  })

   var requisicao = trazerContatos()
   requisicao.done(function(response){
    $("#chats").html(response)

    $('#chats .contato').each(function(i, item){

      trazerUltimaMsg($(item).attr("idChat"))
    });
  })

})

function carregarConteudo(){
  $.ajax({
    url: 'php/carregarConteudo.php',
    method: 'POST',
    error: function(error){
      alert("Ocorreu um erro carregarConteudo.php: " + error.status + " " + error.statusText);
    }
    }).done(function(response) {   
      $("#sec").html(response)
      $(".progress-bar").css("width", "55%")

  })
}

function checkRegisSimu(usu){
  var idUsuario = usu

 return $.ajax({
    url: 'php/checkRegisSimu.php',
    method: 'POST',
    data:{'idUsuario': idUsuario} 
    })
}

//JANELA MODAL simulado
function abrirJanelaModal() {
  $('.mask').addClass("mostrar");

  $('.mostrar').click(function (e) {
    if(e.target.className == "mask mostrar" || e.target.className == "fechar" ){
      fecharJanelaModal()
    }
  })
}
function fecharJanelaModal() {
  $(".mask").removeClass("mostrar");

  $('.btnFazerSimulado').addClass('btnFazerSimuladoHover');
  $(".btnFazerSimulado").html("Fazer Simulado").css({"pointer-events":"auto", "border": "2px solid #001153", "padding": "5px","cursor":"pointer"})

  $(".btnVerQuestoes").hide()
  $(".btnInsQuestao").hide()
  $(".btnEnviarEditQuestao").hide()
}

//JANELA MODAL inserir simulados
function abrirJanelaIns() {
  $(".maskSimu").addClass("mostrarSimu");

  $('.mostrarSimu').click(function (e) {
    if(e.target.className == "maskSimu mostrarSimu" || e.target.className == "fecharSimu" ){
      $(".maskSimu").removeClass("mostrarSimu");
    }
  })
}

function insAlternativas(q, a, ac){
  var idQuestao = q;
  var txtAlternativa = a;
  var altCerta = ac;

  $.ajax({
    url: 'php/ins.php',
    method: 'POST',
    data:{'idQuestao': idQuestao, 'txtAlternativa': txtAlternativa,'alternativa': "table", 'txtAlternativaCerta': altCerta},
    success: function(response){
      if(response == "1"){ 
        $(".btnAddQuestao").trigger("click")
        $(".loadingGif2").hide();
        $(".btnInsQuestao").html("<i class='far fa-smile-wink'></i> Inserida").css({'transform': 'scale(1.05)', "pointer-events":"none"})
        $(".btnInsQuestao").show()

        setTimeout(function(){ 
          $(".btnInsQuestao").html("Adicionar Questão").css({'transform': 'scale(1)', "pointer-events":"auto"})
        }, 3000);
        
        carregarConteudo()
      }else{
        console.log(response)
      }


    }, error: function(error){
      alert("Ocorreu um erro selectRegistroSimu: " + error.status + " " + error.statusText);
    }
  })
}

// --------------------FUNCÕES TELA SIMULADO ------>

function carregarSimulado(){  //funcão que é acionada quando a pag TelaSimulado é carregada
  $(".progress-bar").css("width", "10%")

  var idSimuladoAtual = $("#infotl2").attr("idSimulado");
  var siglaSimulado = $("#infotl2").attr("siglaSimu");

  selectSimulado(idSimuladoAtual, siglaSimulado);
  mostrarQuestoes(idSimuladoAtual);

  setTimeout(function(){ 
    var idSimuladoAtual = $("#infotl2").attr("idSimulado");
    var idUsuario = $("#perfil").attr("id_usuario");

    var promised = checkRegisSimuExiste(idSimuladoAtual, idUsuario)

    promised.done(function(response) {

      if(response == "registroTrue"){
          var idSimuladoAtual = $("#infotl2").attr("idSimulado");
          var idUsuario = $("#perfil").attr("id_usuario");

          mostrarRespostas(idSimuladoAtual, idUsuario);             
      }
    }) 
  }, 500);
}

var cont;
var contAjax;

// QUANDO TERMINA UM SIMULADO ---->
function  mostrarRespostas(simu, usu){
  var idSimulado = simu
  var idUsuario = usu
  contAjax = 0;

  $.ajax({
    url: 'php/selectRespostas.php',
    method: 'POST',
    data:{ 'idSimulado': idSimulado, 'idUsuario': idUsuario},
    success: function(response){
   
      var retorno = response.split("||");
           
      for (var i = 0; i < retorno.length; i++) { 
        var splited = retorno[i].split("|")

        $("#alt_"+$.trim(splited[1])).prop( "checked", true );

        mostrarAlternativaCorreta($.trim(splited[0]), $.trim(splited[1]), retorno.length)
      }
    mostrarRankingUsuarios()
    }, error: function(error){
      alert("Ocorreu um erro selectRegistroSimu: " + error.status + " " + error.statusText);
    }
   })
}

function mostrarAlternativaCorreta(q, r, c, res){
  var idQuestao = q;
  var idAltSelecionada = r;
  var formLenght = c;
  var respostas = res;

  $.ajax({
    url: 'php/selectAltCerta.php',
    method: 'POST',
    data:{ 'idQuestao': idQuestao},
    success: function(response) {
      // alert("Questão: "+idQuestao+" Resposta Certa: "+ response+ " Alternativa Selecionada: "+idAltSelecionada)

      contAjax = contAjax + 1;
      
      if(idAltSelecionada == response){
        cont = cont + 1;
        $("#label_"+idAltSelecionada).css({"box-shadow":"inset 0 0 0 1.5px rgb(1, 86, 65)", "background-color":"white"})
      }else{
        $("#label_"+idAltSelecionada).css({"box-shadow":"inset 0 0 0 1.5px rgb(220 53 76)", "background-color":"white"})

        $("#label_"+response).css({"box-shadow":"inset 0 0 0 1.5px rgb(1, 86, 65)", "background-color":"white"})
      }
      if(contAjax == formLenght){ //quando todas as alternativas forem mostradas
          $('#btnConcluirSimulado').click(false);
          $("#btnConcluirSimulado").html("<i class='fas fa-check'></i>Concluido").css({"background-color": "white", "border": "2px solid rgb(1 86 65)", "padding": "5px","color":"rgb(1 86 65)", "cursor":"auto"})
          $('#btnConcluirSimulado').removeClass('btnHoverEffect'); 

          $(".radioBoxes input").prop('disabled', true).css("cursor","auto")
          $(".radioBoxes label").css("cursor","auto")
          $('.radioBoxes label').removeClass("lblHoverEffect");

          var idUsuario = $("#perfil").attr("id_usuario")
          var idSimuladoAtual = $("#infotl2").attr("idSimulado");


          var promised = checkRegisSimuExiste(idSimuladoAtual, idUsuario)

          promised.done(function(response) {
          if(response !== "registroTrue"){
            $("#resultado").html('Você acertou '+cont+' de '+ formLenght + ' questões.')
               insRegistroSimulado(cont, respostas);
          }     
          })  
      }    
      }, error: function(error){
        alert("Ocorreu um erro questaoReposta.php: " + error.status + " " + error.statusText);
      }
  }); 
} 

function insRegistroSimulado(c, r){
  var qtdAcertos = c;
  var idSimulado = $("#infotl2").attr("idSimulado");
  var idUsuario = $("#perfil").attr("id_usuario");
  var respostas = r;

  respostas = JSON.stringify(respostas);

  $.ajax({
    url: 'php/ins.php',
    method: 'POST',
    data:{ 'idSimulado': idSimulado, 'idUsuario': idUsuario, 'qtdAcertos':  qtdAcertos, 'respostas': respostas, 'registrosimulado':"table"},
    dataType: 'text',
    success: function(response){

      console.log(response)
  
    }, error: function(error){
      alert("Ocorreu um erro selectSimulado: " + error.status + " " + error.statusText);
    }
  })
}

function  mostrarRankingUsuarios(){
  var idUsuario = $("#perfil").attr("id_usuario")
  var idSimulado = $("#infotl2").attr("idSimulado");
  $.ajax({
    url: 'php/selectRanking.php',
    method: 'POST',
    data:{ 'idSimulado': idSimulado, 'idUsuario': idUsuario},
    success: function(response){

      $("#ranking").html(response);
  
    }, error: function(error){
      alert("Ocorreu um erro selectRegistroSimu: " + error.status + " " + error.statusText);
    }
  })
}

//FUNÇOES QUE AS DUAS TELA COMPARTILHAM
function checkRegisSimuExiste(simu, usu){
  var idSimulado = simu
  var idUsuario = usu
    return $.ajax({
    url: 'php/checkRegisSimu.php',
    method: 'POST',
    data:{ 'idSimulado': idSimulado, 'idUsuario': idUsuario} 
    })
}

function selectSimulado(simu, sigla){
  $(".progress-bar").css("width", "25%")

  var idsimulado = simu;
  var sigla = sigla;

  $.ajax({
      url: 'php/selectSimulado.php',
      method: 'POST',
      data:{ 'idsimulado': idsimulado, 'simulado': "table"},
      success: function(response){
       var retorno = response.split("|");

        $(".siglaSimu").text(sigla);

        $(".titulo").text(retorno[0]);
        $(".descricao").text(retorno[1]);
    
      }, error: function(error){
        alert("Ocorreu um erro selectSimulado: " + error.status + " " + error.statusText);
      }
    })
}

function mostrarQuestoes(s){
  var idsimulado = s;
  $(".questoes").empty();

  $.ajax({
  url: 'php/selectSimulado.php',
  method: 'POST',
  data:{ 'idsimulado':  idsimulado, 'questoes':"table"},
  success: function(response) {
    $(".progress-bar").css("width", "75%")

  if(response == "sem questoes"){
     $(".questoes").append("<p>Este simulado não possui questões.</p>");
     $(".btnFazerSimulado").css("display", "none")
     abrirJanelaModal();
     $(".card").children(".loadingGif").hide()
     $(".card").css("pointer-events","auto")
  }else{
    $(".btnFazerSimulado").css("display", "block")
    var retorno = response.split("||");

    $(".formQuestoes").empty();
    

    for (var i = 0; i < retorno.length; i++) { 

      var splited = retorno[i].split("|");

      $(".questoes").append("<p class='Q"+splited[0]+"'><span class='numeroQ'>"+(i+1)+". </span><span class ='txtQuestao'>"+splited[1]+"</spn></p>");


      //botões inserir e deletar, fazer funcionar !!!
      $(".Q"+splited[0]).prepend("<button class='btnEditQuestao' idquestao="+splited[0]+"><i class='far fa-edit'></i></i></button><button class='btnDelQuestao' idquestao="+splited[0]+"><i class='far fa-trash-alt'></i></button>")

      $(".formQuestoes").append("<p id='"+splited[0]+"'><span class='numeroQ'>"+(i+1)+". </span>"+splited[1]+"</p>");

      mostrarAlternativas(splited[0]);
    }
  }
  }, error: function(error){
     alert("Ocorreu um erro selectQuestoes: " + error.status + " " + error.statusText);
  }
  });
}
function mostrarAlternativas(q){
  var idQuestao = q;

  $.ajax({
    url: 'php/selectSimulado.php',
    method: 'POST',
    data:{ 'idQuestao': idQuestao, 'alternativas':"table"},
    success: function(response) {

      var retorno = response.split("||");

      for (var i = 0; i < retorno.length; i++) { 
        
        var alfabeto = "abcdefghijklmnopqrtuvwxyz".substring(i, i+1);
        var splited = retorno[i].split("|")

        $(".Q"+splited[0]).append('<div id="alt_'+splited[1]+'">'+alfabeto+') '+ splited[2]+'</div>');

        $("#"+splited[0]).append('<div class="radioBoxes"><label for="alt_'+splited[1]+'" class="lblHoverEffect" id="label_'+splited[1]+'"><input type="radio" id="alt_'+splited[1]+'" name="'+idQuestao+'" value="'+splited[1]+'" class="'+i+'"/><span>'+ splited[2]+'</span></label></div>');
      } 

      if($("#perfil").attr("funcao") != "administrador"){
        $(".btnEditQuestao").css("display","none")
        $(".btnDelQuestao").css("display","none")
      }
     
      abrirJanelaModal();
      $(".progress-bar").css("width", "100%")
      $(".progress-bar").hide()
      $(".card").children(".loadingGif").hide()
      $(".card").css("pointer-events", "auto")
    }
  });
}


function serializeFormJSON(f) { //transforma um array para formato de arquivo json
  var o = {};
  var a = f.serializeArray();

  $.each(a, function () {
      if (o[this.name]) {
          if (!o[this.name].push) {
              o[this.name] = [o[this.name]];
          }
          o[this.name].push(this.value || '');
      } else {
          o[this.name] = this.value || '';
      }
  });
  return o;
}



//------------------------------------------------------------------------------
//---------------------------------!CHAT!-----------------------------------------

var idUsuario = $("#perfil").attr("id_usuario")

var conn = new WebSocket('ws://localhost:8080?idUsuario='+idUsuario+'');
conn.onopen = function(e) {
  console.log("Connection established!")
}    


$(document).on("click", ".btnAbrirChat", function () {

  var idUsuOutro = $(this).attr("idUsuario")
  var nome = $(this).attr("nome")
  var foto = $(this).attr("foto")

  var requisicao = trazerContatos()
  requisicao.done(function(response){

    $("#chats").html(response)

    $('#chats .contato').each(function(i, item){
      trazerUltimaMsg($(item).attr("idChat"))
    });

    requisicao = checarChatExiste(idUsuOutro)
    requisicao.done(function(response){
      if(response != 1){

        $("#chats").prepend("<a class = 'contato' idUsuario = '"+idUsuOutro+"' nome = '"+nome+"'' idChat = ' '> <img  src= '"+foto+"'> <p href='#'>"+nome+"<span></span></p></a>")
      }
      openNav();
      $( ".contato[idUsuario="+idUsuOutro+"]" ).trigger( "click");

    })

  })
  
})

$(document).on("click", ".contato", function () {
  $("#boxMsgs").empty();

  $(this).css("background-color", "#121d27")
  $(this).children("figure").remove()

  $(".conversa").css("visibility", "visible")

  var idUsuario = $(this).attr("idUsuario")
  var foto = $(this).children("img").attr("src")
  var nome = $(this).attr("nome")
  var idChat = $(this).attr("idChat")


  $(".infoContato").attr("idUsuario", idUsuario)
  $(".fotousuario").attr("src", foto)
  $(".nomeusuario").text(nome)
  $(".infoContato").attr("idChat", idChat)

  trazerMensagens(idChat);

  updateMsgVista(idUsuario)

 var requisicao = selectIdConexao(idUsuario)
    requisicao.done(function(response) {

      idConexaoContAtual = response;
      $(".infoContato").attr("idConexaoContAtual", idConexaoContAtual)

  })

})

$(document).on("click", "#fecharConversa", function () {
  $(".conversa").css("visibility", "hidden")
  $(".infoContato").attr("idConexaoContAtual", " ")
})

$(document).keypress(function(e) {
    if(e.which == 13) $('#btnEnviarMsg').click();
});

$(document).on("click", "#btnEnviarMsg", function () {

  if($("#inputMsg").val() == " " || !$('#inputMsg').val().trim()){
      $(this).css("color","#a5a5a5") 
  }else{
    $(this).css("color","white") 

    var idConexaoSua = 0
    var idConexaoContAtual =  $(".infoContato").attr("idConexaoContAtual")
    var idUsuario = $("#perfil").attr("id_usuario")


    var requisicao = selectIdConexao(idUsuario)
      requisicao.done(function(response) {  
      idConexaoSua = response;

      var msg = $("#inputMsg").val()

      var data = {'destinatarioID': idConexaoContAtual, 'remetente':  idConexaoSua, 'msg': msg, 'remetenteIdUsuario': idUsuario}

      data = JSON.stringify(data)

      $("#inputMsg").val(" ")

      $("#boxMsgs").append("<div class='msg' style = 'align-self:flex-end' ><p style='background-color:#725bb0'>"+msg+"</p></div>")

      $('#boxMsgs').scrollTop($('#boxMsgs')[0].scrollHeight);


      requisicao = insMensagem(msg)
      requisicao.done(function(response){  //inserir mensagem na tabela mensagens
        var idMsg = response;
        var idUsuario = $("#perfil").attr("id_usuario")
        var idUsuOutro = $(".infoContato").attr("idUsuario")

        if($("#boxMsgs").children().length == 1){ //caso a mensagem seja a primeira enviada

          var requisicao = insChat()
          requisicao.done(function(response) {
            var idChat = response
            $(".infoContato").attr("idChat", idChat)

            primeiroInsRegisChat(idUsuario, idUsuOutro, idChat, idMsg)

            var requisicao = trazerContatos()
            requisicao.done(function(response){
              $("#chats").html(response)

              $('#chats .contato').each(function(i, item){
                trazerUltimaMsg($(item).attr("idChat"))
              });

              conn.send(data)
            })

          })
        }else{ // se a mensagem n for a primeira do chat
          var idChat = $(".infoContato").attr("idChat")

          requisicao = insRegisChatMensagem(idUsuario, idChat, idMsg)
          requisicao.done(function(response){
            console.log(response)
            trazerUltimaMsg(idChat)

          })

          conn.send(data)
        }
         
      })

    }) 
  }
})

conn.onmessage = function(e) {
  var data = JSON.parse(e.data);

  if(data.saindo == "sim"){ //outro usu deslogou 
  
    $.ajax({
    url: 'chat/updateStatus.php',
    method: 'POST',
    data:{ 'idConexao': data.idConexao},
    success: function(response) {
     $(".contato[idUsuario="+response+"]").children("i").css("color", "#801212")
    }
  })

  }else if(data.entrando == "sim"){ //outro usu logou 

  if($(".contato[idUsuario="+data.idUsuario+"] i").val() != "undefined"){
    $(".contato[idUsuario="+data.idUsuario+"] i").css("color", "#128043")
  }

   

  }else{ //outro usuario te enviou mensagem

    $(".itens-nav li .far").css({"color": "red", "transform": "scale(1.1)"})

    $(".contato[idUsuario="+data.remetenteIdUsuario+"] p span").empty()
    $(".contato[idUsuario="+data.remetenteIdUsuario+"] p span").append(data.msg)

    setTimeout(function(){ 
        $(".itens-nav li .far").css("transform", "scale(1)")
      }, 1100);


    if($(".infoContato").attr("idConexaoContAtual") == data.remetente){
      $("#boxMsgs").append("<div class='msg' style ='align-self:flex-start' ><p style='background-color:#358f8e'>"+data.msg+"</p></div>")

      $('#boxMsgs').scrollTop($('#boxMsgs')[0].scrollHeight);

      var idChat = $(".infoContato[idConexaoContAtual="+data.remetente+"]").attr("idChat")

  
    }else{ //contato não está aberto ou n tá na lista

      var contatoNaLista = "n";

      $('#chats .contato').each(function(i, item){ //percorrendo todos os meus contatos
      
        if($(item).attr("idUsuario") == data.remetenteIdUsuario){//se o contato tiver na minha lista de chat
          contatoNaLista = "s"  
        }

      }) //fim for 

      if(contatoNaLista == "s"){
  
        $(".contato[idUsuario="+data.remetenteIdUsuario+"]").css("background-color","rgb(26 34 53)")
        $(".contato[idUsuario="+data.remetenteIdUsuario+"]").children("figure").remove()
        $(".contato[idUsuario="+data.remetenteIdUsuario+"]").append("<figure class='fas fa-comment-medical'></figure>")

        $(".contato[idChat="+idChat+"] p span").append(data.msg)

      }else{ //n tenho o contato na minha lista de chat

        var requisicao = trazerContatos()
        requisicao.done(function(response){
        $("#chats").html(response)

         $('#chats .contato').each(function(i, item){
            trazerUltimaMsg($(item).attr("idChat"))
          });

        $(".contato[idUsuario="+data.remetenteIdUsuario+"]").css("background-color","rgb(26 34 53)")
        $(".contato[idUsuario="+data.remetenteIdUsuario+"]").children("figure").remove()
        $(".contato[idUsuario="+data.remetenteIdUsuario+"]").append("<figure class='fas fa-comment-medical'></figure>")

        })        
       
      }

    }
  }//fim else outro usuario te enviou mensagem
} //fim função onmessage

function selectIdConexao(id){
  idUsuario = id;

  return $.ajax({
    url: 'chat/selectIdConexao.php',
    method: 'POST',
    data:{'idUsuario': idUsuario} 
    })
}

function trazerContatos(){
  var idUsuario = $("#perfil").attr("id_usuario")
   return $.ajax({
      url: 'chat/selectChats.php',
      method: 'POST',
      data:{ 'idUsuario': idUsuario}
    })

}

function trazerMensagens(c){
  var idUsuario = $("#perfil").attr("id_usuario")
  var idChat = c;
  $.ajax({
    url: 'chat/selectMensagens.php',
    method: 'POST',
    data:{ 'idChat': idChat, "idUsuario": idUsuario},
    success: function(response) {
      $("#boxMsgs").html(response)
      $('#boxMsgs').scrollTop($('#boxMsgs')[0].scrollHeight);
    }
  })

}

function trazerUltimaMsg(i){
  var idChat = i;

    $.ajax({
    url: 'chat/selectUltimaMsg.php',
    method: 'POST',
    data:{ 'idChat': idChat},
    success: function(response) {

    var retorno = response.split("|");

    $(".contato[idChat="+idChat+"] p span").empty()
    $(".contato[idChat="+idChat+"] p span").append(retorno[0])

    var idUsuario = $("#perfil").attr("id_usuario")
    if(retorno[2] !== idUsuario){ //vc não enviou a ultima mensagem 
      if(retorno[1] == 0){ //tem mensagem n lida

        $(".contato[idUsuario="+retorno[2]+"]").css("background-color","rgb(26 34 53)")

        $(".contato[idUsuario="+retorno[2]+"]").children("figure").remove()
        $(".contato[idUsuario="+retorno[2]+"]").append("<figure class='fas fa-comment-medical'></figure>")

        $(".itens-nav li .far").css("color", "red")
      }
      
    }
    }
  })

}

function insChat(){
  return $.ajax({
    url: 'chat/ins.php',
    method: 'POST',
    data:{'chat': "table"},
  })
}

function insMensagem(m){
  var msg = m;

  return $.ajax({
    url: 'chat/ins.php',
    method: 'POST',
    data:{ "msg": msg},
  })
}

function primeiroInsRegisChat(idCriou, idUsu, idChat, idMsg){
  var idUsuCriou = idCriou
  var idUsuOutro = idUsu
  var idChat = idChat
  var idMsg = idMsg;

  $(".infoContato").attr("idChat", idChat)

  $.ajax({
    url: 'chat/ins.php',
    method: 'POST',
    data:{ 'idChat': idChat,'idUsuCriou': idUsuCriou, 'idUsuOutro': idUsuOutro,'idMsg': idMsg,'primeiroRegistroChatMsg': "table"},
    success: function(response) {

      console.log(response)
    }
  })
}

function insRegisChatMensagem(u, c, m){
  var idUsuario = u;
  var idChat = c;
  var idMsg = m

   return $.ajax({
    url: 'chat/ins.php',
    method: 'POST',
    data:{ 'idUsuario': idUsuario, 'idChat': idChat, 'idMsg': idMsg, 'insRegisChatMsg': "table"},
  }) 

}

function checarChatExiste(id){
  var idUsuOutro = id;
  var idUsuario = $("#perfil").attr("id_usuario")

  return $.ajax({
    url: 'chat/checkChatExiste.php',
    method: 'POST',
    data:{ "idUsuario": idUsuario, "idUsuOutro": idUsuOutro},
  })
}

function updateMsgVista(id){
   var idUsuOutro = id;

    $.ajax({
    url: 'chat/updateUltimaMsgVista.php',
    method: 'POST',
    data:{ 'idUsuOutro': idUsuOutro},
    success: function(response) {
      console.log(response)
    }
  })   
}


// PERFIL -----------------------------
$(document).on("click", "#meuPerfil", function () {
  $(".maskPerfil").addClass("mostrarPerfil");

  var idUsuario = $("#perfil").attr("id_usuario")
   $.ajax({
    url: 'php/lerDadosUsu.php',
    method: 'POST',
    data:{ 'idUsuario': idUsuario},
    success: function(response) {

      var retorno = response.split("|");

      $("#usuFoto").attr("src", "data:image/jpeg;base64,"+ retorno[0])
      $("#usuNome").text(retorno[1])  
      $("#usuNomeDeUsu").text(retorno[2])   
      $("#usuDescricao").text(retorno[3])    
      $("#usuDataCadastro").text(retorno[4])       

    }
  })   

  $('.mostrarPerfil').click(function (e) {
    if(e.target.className == "maskPerfil mostrarPerfil" || e.target.className == "fecharPerfil" ){
      $(".maskPerfil").removeClass("mostrarPerfil");
    }
  })
})


$(document).on("click", "#btnEditPerfil", function () {
  $(".maskPerfilEdit").addClass("mostrarPerfilEdit");

  $(".mostrarPerfil").trigger("click")

    $("#imgFoto").attr("src", $("#usuFoto").attr("src"))

    $("#txtNomeCompleto").val($("#usuNome").text())
    $("#txtNomeUsuario").val($("#usuNomeDeUsu").text())
    $("#txtDescricao").val($("#usuDescricao").text())

  $('.mostrarPerfilEdit').click(function (e) {
    if(e.target.className == "maskPerfilEdit mostrarPerfilEdit" || e.target.className == "fecharPerfilEdit" ){

      $(".maskPerfilEdit").removeClass("mostrarPerfilEdit");

      $("#meuPerfil").trigger("click")

    }
  })
})
$(".formPerfilEdit").submit(function(e) {
  e.preventDefault();

 $('#txtFoto').val($('#imgFoto').attr('src'));

  var idUsuario = $("#perfil").attr("id_usuario")

  var serializeDados = $('.formPerfilEdit').serialize()+"&idUsuario="+idUsuario

  $.ajax({
    url: "php/editUsuario.php",
    method: 'POST',
    data: serializeDados,
    success: function(response) {
      console.log(response)

      $("#meuPerfil").trigger("click")
      $(".maskPerfilEdit").removeClass("mostrarPerfilEdit");

      $("#perfil").attr("src", $('#imgFoto').attr('src'))



    }, error: function(error){
      alert("Ocorreu um erro: " + error.status + " " + error.statusText)
    }         

  });
})


$('#labelFoto').on('click', function() {
  $('#fileFoto').trigger('click');
});

$("#fileFoto").change(function () { 

  if (this.files && this.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) { 
      
      $('#imgFoto').attr('src', e.target.result);

    } 
    reader.readAsDataURL(this.files[0]);
  }
});


// PESQUISA
$(document).on("submit", "#forms_search", function (e) {
  e.preventDefault()

  $.ajax({
  url: "php/pesquisa.php",
  method: 'GET',
  data: {"txtPesquisa": $("#txtPesquisa").val()},
  success: function(response) {
    $("#sec").html(response)

  }, error: function(error){
    alert("Ocorreu um erro: " + error.status + " " + error.statusText)
  }         

  });
})

$(document).on("click", "#btnVoltar", function () {
  carregarConteudo()

  $("#txtPesquisa").val("")
})