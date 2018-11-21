<?php
    session_start();
    if(!isset($_SESSION['usuario_id']))
        $_SESSION['usuario_id'] = '';
    if(!isset($_SESSION['tipo_usuario']))
        $_SESSION["tipo_usuario"] = "";
    if(!isset($_SESSION['mensagem']))
		$_SESSION['mensagem'] = '';
    //Informações do banco de dados
    $servername = "localhost";
	$username = "root";
	$password = "123456";
	$dbname = "JoestarCompany";

	//Cria conexão com o banco
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	//Checa conexão com o banco
	if (mysqli_connect_error()) {
		die("Connection failed: " . mysqli_connect_error());
    }

    //seleciona todas as viagens disponíveis
    if($_SESSION['tipo_usuario'] == 'adm')
        $sql="select c.id, c.id_viagem, c.id_usuario, u.login, u.nome, v.destino, v.data_partida, c.preco, c.forma_pagamento, c.estado from Compra c inner join Viagem v on v.id=c.id_viagem inner join Usuario u on u.id=c.id_usuario;";
    else
        $sql="select c.id, c.id_viagem, c.id_usuario, u.login, u.nome, v.destino, v.data_partida, c.preco, c.forma_pagamento, c.estado from Compra c inner join Viagem v on v.id=c.id_viagem inner join Usuario u on u.id=c.id_usuario where c.id_usuario=".$_SESSION['usuario_id'].";";
    $sql_resultado = mysqli_query($conn,$sql);
?>

<html>
    <head>
        <title> Agência de Viagens - Viagens </title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<link rel='stylesheet' href='estilo.css' type='text/css' />
    </head>

    <body>
        <div id='topo'>
            <ul id='menu'>
                <?php
                    //Menu diferente de acordo com o tipo de usuário
                    if($_SESSION['tipo_usuario'] == ""){
                        echo "
                        <li><a href='home.php'>Home</a></li>
                        <li><a href='consultar_viagens.php'>Viagens</a></li>
                        <li><a href='login.php'>Login</a></li>
                        ";
                    } else if($_SESSION['tipo_usuario'] == 'cliente'){
                        echo "
                        <li><a href='home.php'>Home</a></li>
                        <li><a href='consultar_viagens.php'>Viagens</a></li>
                        <li><a href='ver_perfil.php'>Perfil</a></li>
                        <li><a href='consulta_compras.php'>Compras</a></li>
                        <li><a href='logout.php'>Logout</a></li>
                        ";
                    } else if($_SESSION['tipo_usuario'] == 'adm'){
                        echo "
                        <li><a href='home.php'>Home</a></li>
                        <li><a href='consultar_viagens.php'>Viagens</a></li>
                        <li><a href='ver_perfil.php'>Perfil</a></li>
                        <li><a href='consulta_compras.php'>Compras</a></li>
                        <li><a href='ver_usuarios.php'>Usuários</a></li>
                        <li><a href='cadastrar_viagem.php'>Nova viagem</a></li>
                        <li><a href='cadastrar_usuario.php'>Novo adm</a></li>
                        <li><a href='logout.php'>Logout</a></li>
                        ";
                    }
                ?>	
			</ul>
        </div>
        <table align='center' border='0' width =100%>
        <tr>
        
        <td width=70% valign='top'>
        <table align='center' border='1' width =100%>
                <tr  align='center'>   
                    <td colspan='8' ><h1>Viagens oferecidas</h1></td>
                </tr>
                <tr align='center'>
                    <th>ID da compra</th>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Destino</th>
                    <th>Data de partida</th>
                    <th>Preço</th>
                    <th>Forma de pagamento</th>
                    <th>Estado</th>
                </tr>

                <?php
                    //Mostra informações de todas as compras
                    //Exibe opção de cancelar se viagem for daqui a 15 dias ou mais
                    if(mysqli_num_rows($sql_resultado)>0){ 
                        while($row = mysqli_fetch_assoc($sql_resultado)){
                            $tempo_limite = strtotime('+15 days');
                                if($row["estado"]=="Efetivado" && strtotime($row["data_partida"])>=$tempo_limite){
                                    $var = "<a href='consulta_compras2.php?id=".$row["id"]."'>(Cancelar)</a>";
                                } else{
                                    $var = "";
                                }
                                echo "
                                <tr align='center'>   
                                    <td>".$row["id"]."</td>
                                    <td>".$row["nome"]."</td>
                                    <td>".$row["login"]."</td>
                                    <td>".$row["destino"]."</td>
                                    <td>".$row["data_partida"]."</td>
                                    <td>".$row["preco"]."</td>
                                    <td>".$row["forma_pagamento"]."</td>
                                    <td>".$row["estado"]."$var</td>
                                ";
                                echo"
                                </tr>
                            ";
                            }
                    }
                ?>
        </td>
            </table>
        </tr>
        </table>

		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>
</html>