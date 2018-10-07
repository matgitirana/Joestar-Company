<?php

    session_start();
    if(!isset($_SESSION['usuario_sessao'])){
        $_SESSION['usuario_sessao'] = '';
    }

    $arquivo_viagens = "arquivos/viagens.txt";
    $arquivo_viagens_dos_sonhos = "arquivos/viagens_dos_sonhos.txt";
    $conteudo = file_get_contents($arquivo_viagens);
    if(filesize($arquivo_viagens_dos_sonhos) !=0)
        $conteudo = $conteudo . "\r\n" . file_get_contents($arquivo_viagens_dos_sonhos);
    // Separa as linhas
    $linhas = explode ("\r\n", $conteudo);
    
    // Separa os registros
    for ($i = 0; $i < sizeof($linhas); $i++) {
        list($destinos[$i], $datas[$i],$diarias[$i], $transportes[$i], $translados[$i], $estrelas[$i], $passeios[$i], $user[$i])= explode ("|", $linhas [$i]);
    }

    $arquivo_usuario = "arquivos/usuarios.txt";
    $conteudo = file_get_contents($arquivo_usuario);
    // Separa as linhas
    $linhas_usuario = explode ("\r\n", $conteudo);

    // Separa os registros
    for ($i = 0; $i < sizeof($linhas_usuario); $i++) {
        list($nome[$i], $sobrenome[$i], $data[$i], $endereco[$i], $telefone[$i], $sexo[$i], $rg[$i], $cpf[$i], $foto[$i], $usuario[$i], $senha[$i]) = explode ("|", $linhas_usuario [$i]);
    }
    for ($i = 0; $i < sizeof($linhas_usuario); $i++) {
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
                <?php
                    if($_SESSION['usuario_sessao'] == ''){
                        echo "<li><a href='login.php'>Login</a></li>";
                    } else{
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                ?>

                
			</ul>
        </div>

        <div>
        <table align='center' border='0' width =100%>
        
        <tr>
        <?php
        if($_SESSION['usuario_sessao'] != ''){
            echo "<td width='30%'>
            <table align='center' border='0' width =100%>
                <tr  align='center'>   
                    <td colspan='10' ><h1>Usuário</h1></td>
                </tr>";
                
        
                for($i=0;$i<sizeof($linhas_usuario);$i++){
                    if($usuario[$i]==$_SESSION['usuario_sessao']){
                        echo "
                            <tr>   
                                <th>Nome</th>    
                                <td>$nome[$i]</td>
                            <tr>
                            <tr>   
                                <th>Sobrenome</th>    
                                <td>$sobrenome[$i]</td>
                            <tr>
                            <tr>   
                                <th>Data de nascimento</th>    
                                <td>$data[$i]</td>
                            <tr>
                            <tr>   
                                <th>Enderço</th>    
                                <td>$endereco[$i]</td>
                            <tr>
                            <tr>   
                                <th>Telefone</th>    
                                <td>$telefone[$i]</td>
                            <tr>
                            <tr>   
                                <th>Sexo</th>    
                                <td>$sexo[$i]</td>
                            <tr>
                            <tr>   
                                <th>RG</th>    
                                <td>$rg[$i]</td>
                            <tr>
                            <tr>   
                                <th>CPF</th>    
                                <td>$cpf[$i]</td>
                            <tr>
                            <tr>   
                                <th>Login</th>    
                                <td>$usuario[$i]</td>
                            <tr>
                            <tr>   
                                <td colspan='2'><img width ='80%' src = '$foto[$i]'></td>
                            <tr>
                            ";
                    }
                }
            echo "
            </table>
        </td>
        ";
        }
        ?>
        <td width=70% valign='top'>
        <table align='center' border='0' width =100%>
                <tr  align='center'>   
                    <td colspan='8' ><h1>Viagens oferecidas</h1></td>
                </tr>
                <tr align='center'>   
                    <th>Destino</th>
                    <th>Data de Partida</th>
                    <th>Diárias</th>
                    <th>Transporte</th>
                    <th>Translado Pago</th>
                    <th>Hospedagem</th>
                    <th>Passeios Pago</th>
                    <th>Custo</th>
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

                <?php
                    if($_SESSION['usuario_sessao'] != ''){
                        echo "
                        <tr  align='center' valign='bottom'>   
                            <td colspan='8' ><p>Cadastre uma <a href='viagem_dos_sonhos.php'>viagem dos sonhos</a></p></td>
                        </tr>";
                    }
                ?>



                
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