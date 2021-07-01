<!-- janela modal que aparece ao clicar no mais de inserir simulado -->

<div id="boxSimu"> 
        <form id = "formInsAltSimu">
          <div class="fecharSimu">X</div>

            <input type="hidden" name="txtIdSimu" id="txtIdSimu" />

            <p>Nome</p>
            <input type="text" name="txtNome" id="txtNome" placeholder="Digite o nome do simulado" required/>

            <p>Descrição</p>
            <textarea id="txtDescricao" name="txtDescricao"   placeholder="Descreva sobre o que o simulado é" required></textarea>
            
            <input type="submit" id="btnEnviarSimulado" value="Enviar">
        </form>
</div>

