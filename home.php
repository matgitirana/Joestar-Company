<?php

    session_start();
    if(!isset($_SESSION['usuario_sessao'])){
        $_SESSION['usuario_sessao'] = '';
    }

    $arquivo_viagens = "arquivos/viagens.txt";
    $arquivo_viagens_dos_sonhos = "arquivos/viagens_dos_sonhos.txt";
    $conteudo = file_get_contents($arquivo_viagens);
    $conteudo = $conteudo . "\r\n" . file_get_contents($arquivo_viagens_dos_sonhos);
    // Separa as linhas
    $linhas = explode ("\r\n", $conteudo);
    // Separa os registros
    for ($i = 0; $i < sizeof($linhas); $i++) {
        list($destinos[$i], $datas[$i],$diarias[$i], $transportes[$i], $translados[$i], $estrelas[$i], $passeios[$i], $user[$i])= explode ("|", $linhas [$i]);
    }

    echo $conteudo;
    $arquivo_usuario = "arquivos/usuarios.txt";
    $conteudo = file_get_contents($arquivo_usuario);
    // Separa as linhas
    $linhas = explode ("\r\n", $conteudo);

    // Separa os registros
    for ($i = 0; $i < sizeof($linhas); $i++) {
        list($nome[$i], $sobrenome[$i], $data[$i], $endereco[$i], $telefone[$i], $sexo[$i], $rg[$i], $cpf[$i], $foto[$i], $usuario[$i], $senha[$i]) = explode ("|", $linhas [$i]);
    }
    for ($i = 0; $i < sizeof($linhas); $i++) {
        if($sexo[$i]=='m'){
            $sexo[$i] = "Masculino";
        } else if($sexo[$i]=='f'){
            $sexo[$i] = "Feminino";
        } else{
            $sexo[$i] = "Outro";
        }
    }

    $custo = 0;
    
?>

<html>
    <head>
        <title> Agência de Viagens - Viagem dos Sonhos </title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<link rel='stylesheet' href='estilo.css' type='text/css' />
    </head>

    <body>

        <div id='topo'>
            <ul id='menu'>
                <li><a href='logout.php'>Logout</a></li>
			</ul>
        </div>

        <div>
        <table align='center' border='0' width =100%>
        <tr>
            <td width="30%">
                <table align='center' border='0' width =100%>
                    <tr  align='center'>   
                        <td colspan='10' ><h1>Usuário</h1></td>
                    </tr>
                    
            
                <?php
                    for($i=0;$i<sizeof($linhas);$i++){
                        if($usuario[$i]==$_SESSION['usuario_sessao']){
                            echo "
                                <tr>   
                                    <td>Nome</td>    
                                    <td>$nome[$i]</td>
                                <tr>
                                <tr>   
                                    <td>Sobrenome</td>    
                                    <td>$sobrenome[$i]</td>
                                <tr>
                                <tr>   
                                    <td>Data de nascimento</td>    
                                    <td>$data[$i]</td>
                                <tr>
                                <tr>   
                                    <td>Enderço</td>    
                                    <td>$endereco[$i]</td>
                                <tr>
                                <tr>   
                                    <td>Telefone</td>    
                                    <td>$telefone[$i]</td>
                                <tr>
                                <tr>   
                                    <td>Sexo</td>    
                                    <td>$sexo[$i]</td>
                                <tr>
                                <tr>   
                                    <td>RG</td>    
                                    <td>$rg[$i]</td>
                                <tr>
                                <tr>   
                                    <td>CPF</td>    
                                    <td>$cpf[$i]</td>
                                <tr>
                                <tr>   
                                    <td>Login</td>    
                                    <td>$usuario[$i]</td>
                                <tr>
                                <tr>   
                                    <td colspan='2'><img width ='80%' src = '$foto[$i]'></td>
                                <tr>


                                   
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                        
                            ";
                        }
                        
                    }


                ?>
                </table>
            </td>
        
        <td width=70% valign='top'>
        <table align='center' border='0' width =100%>
                <tr  align='center'>   
                    <td colspan='8' ><h1>Viagens oferecidas</h1></td>
                </tr>
                <tr align='center'>   
                    <td>Destino</td>
                    <td>Data de Partida</td>
                    <td>Diárias</td>
                    <td>Transporte</td>
                    <td>Translado Pago</td>
                    <td>Hospedagem</td>
                    <td>Passeios Pago</td>
                    <td>Custo</td>
                </tr>

                <?php
                    for($i=0;$i<sizeof($linhas);$i++){
                        if($user[$i]=="" || $user[$i]==$_SESSION['usuario_sessao']){
                            $custo = $diarias[$i]*100 + $estrelas[$i]*500;
                            if($transportes[$i] == "Aviao"){
                                $custo+=2000;
                            } else if($transportes[$i] == "Trem"){
                                $custo+=500;
                            }else if($transportes[$i] == "Navio"){
                                $custo+=1000;
                            }
                            if($translados[$i]=="Sim"){
                                $custo+=500;
                            }
                            if($passeios[$i]=="Sim"){
                                $custo+=500;
                            }
                            echo "
                                <tr  align='center'>   
                                    <td>$destinos[$i]</td>
                                    <td>$datas[$i]</td>
                                    <td>$diarias[$i]</td>
                                    <td>$transportes[$i]</td>
                                    <td>$translados[$i]</td>
                                    <td>$estrelas[$i] Estrelas</td>
                                    <td>$passeios[$i]</td>
                                    <td>\$$custo</td>
                                </tr>
                            ";
                        }
                        
                    }


                ?>
                <tr  align='center' valign='bottom'>   
                    <td colspan='8' ><p>Cadastre uma <a href='viagem_dos_sonhos.php'>viagem dos sonhos</a></p></td>
                </tr>
        </td>
            

            </table>
            </tr>
        </table>
            

        </div>


		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>

</html>