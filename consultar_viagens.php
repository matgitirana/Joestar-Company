<?php
    session_start();
    if(!isset($_SESSION['usuario_id']))
        $_SESSION['usuario_id'] = '';
    if(!isset($_SESSION['tipo_usuario']))
        $_SESSION["tipo_usuario"] = "";

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

    //seleciona todas as viagens que disponíveis
    $sql="select id, destino, data_partida, diarias, transporte, status,preco_diaria, preco_translado from Viagem where status='1';";
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
                        <li><a href='logout.php'>Logout</a></li>
                        ";
                    } else if($_SESSION['tipo_usuario'] == 'adm'){
                        echo "
                        <li><a href='home.php'>Home</a></li>
                        <li><a href='consultar_viagens.php'>Viagens</a></li>
                        <li><a href='ver_perfil.php'>Perfil</a></li>
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
        <table align='center' border='0' width =100%>
                <tr  align='center'>   
                    <td colspan='8' ><h1>Viagens oferecidas</h1></td>
                </tr>
                <tr align='center'>   
                    <th>Destino</th>
                    <th>Data de Partida</th>
                    <th>Diárias</th>
                    <th>Transporte</th>
                    <th>Preço</th>
                </tr>

                <?php
                    //Mostra informações de todas as viagens disponíveis
                    if(mysqli_num_rows($sql_resultado)>0){ 
                        $preco = 0;
                        while($row = $sql_resultado->fetch_assoc()){
                                //Preço do transporte
                                $sql="select preco from Transporte where transporte='". $row["transporte"] ."';";
                                $preco_select = mysqli_query($conn,$sql);
                                $preco_transporte = $preco_select->fetch_assoc();
                                //Calcula preço
                                $preco = $row["diarias"]*$row["preco_diaria"]+$preco_transporte["preco"]+$row["preco_translado"];
                                echo "
                                <tr align='center'>   
                                    <td>".$row["destino"]."</td>
                                    <td>".$row["data_partida"]."</td>
                                    <td>".$row["diarias"]."</td>
                                    <td>".$row["transporte"]."</td>
                                    <td>\$$preco</td>
                                    <td><a href=viagem_detalhes.php?id=". $row["id"] .">Detalhes da viagem</td>
                                    ";
                                    if($_SESSION['tipo_usuario']=='adm'){
                                        echo"<td><a href=deletar_viagem.php?id=". $row["id"] .">Deletar viagem</td>
                                        ";
                                    }
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