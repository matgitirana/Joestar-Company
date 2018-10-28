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

    //seleciona todas as viagens
    $sql="select id, destino, status, diarias, caminho_foto from Viagem where status='1';";
    $sql_resultado = mysqli_query($conn,$sql);
    
    $preco = 0;
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

        <h1 align='center'>Bem vindo à Joestar Company</h1>
        <h4 align='center'>As melhores viagens com os melhores preços</h4>
        <p align='center'>Bem vindo, caro visitante. Aqui na Joestar Company você encontra ótimas viagens com preços acessíveis</p>
        <p align='center'><img width ='30%' src='fotos/logo.png' alt='logo'></p>

        <?php
        //Mostra foto e destino das viagens disponíveis
        if(mysqli_num_rows($sql_resultado)>0){
            echo"
                    <table align='center' border='0' width =100%>
                    <tr>
                    
                    <td width=70% valign='top'>
                    <table align='center' border='0' width =70%>
                            <tr  align='center'>   
                                <td colspan='8' ><h1>Algumas de nossas viagens</h1></td>
                            </tr>
            ";
            while($row = $sql_resultado->fetch_assoc()){
                    echo"

                            <tr align='center'>   
                                <td><a href=viagem_detalhes.php?id=". $row["id"] ."><img  width='50%' src='".$row['caminho_foto']."' alt='imagem da viagem'></a></td>
                                <td width='50%' align='left'>Viagem para ".$row['destino']." com estadia de ".$row['diarias']." dias.</td>
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