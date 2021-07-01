<?php

if(isset($_SESSION['simuladoAtual']) && isset(($_SESSION['sigla']))){
    unset($_SESSION['simuladoAtual']);
    unset($_SESSION['sigla']);
}
?>