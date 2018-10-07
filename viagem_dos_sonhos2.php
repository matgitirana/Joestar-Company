<?php
    session_start();
    // $_SESSION["usuario_sessao"];
    $destino=$_POST['destino'];
    $data=$_POST['data'];
    $diarias=$_POST['diarias'];
    $transporte=$_POST['transporte'];
    $translado=$_POST['translado'];
    $hospedagem=$_POST['hospedagem'];
    $passeios=$_POST['passeios'];

    $valido=true;
    if(strlen($destino)==0){
        $valido=false;
    } else if(strlen($diarias)<1){
        $valido=false;
    } else if(strlen($hospedagem)==0){
        $valido=false;
    }

    if($valido) {
        $destino_texto= $destino . '|' . $data . '|' . $diarias . '|' . $transporte . '|' . $translado . '|' . $hospedagem . '|' . $passeios . '|' . $_SESSION["usuario_sessao"];
        $arquivo_sonhos='arquivos/viagens_dos_sonhos.txt';
        $conteudo = file_get_contents($arquivo_sonhos);
        if($conteudo!="")
            $conteudo .= "\r\n".$destino_texto;
        else
        $conteudo .= $destino_texto;
        file_put_contents($arquivo_sonhos, $conteudo);
        header("Location: home.php");
    }
?>