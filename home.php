<?php
    session_start();
    if(!isset($_SESSION['usuario_sessao'])){
        $_SESSION['usuario_sessao'] = '';
        $_SESSION["tipo_usuario"] = "";
    }

    $servername = "localhost";
	$username = "root";
	$password = "123456";
	$dbname = "JoestarCompany";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

    //seleciona todas as viagens que não são viagem dos sonhos
    $sql="select id, destino, status, diarias, caminho_foto from Viagem;";
    $sqlResult = $conn->query($sql);
    
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
                    if($_SESSION['usuario_sessao'] == ''){
                        echo "<li><a href='login.php'>Login</a></li>";
                    } else{
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                ?>
			</ul>
        </div>

        <h1 align='center'>Bem vindo à Joestar Company</h1>
        <h4 align='center'>As melhores viagens com os melhores preços</h4>
        <p align='center'>Bem vindo, caro visitante. Aqui na Joestar Company você encontra ótimas viagens com preços acessíveis</p>
        <p align='center'><img width ='30%' src='fotos/logo.png' alt='logo'></p>

        <?php
        if($sqlResult->num_rows>0){
            echo"
                    <table align='center' border='0' width =100%>
                    <tr>
                    
                    <td width=70% valign='top'>
                    <table align='center' border='0' width =70%>
                            <tr  align='center'>   
                                <td colspan='8' ><h1>Algumas de nossas viagens</h1></td>
                            </tr>
            ";
            while($row = $sqlResult->fetch_assoc()){
                if($row["status"]=='1'){
                    echo"

                            <tr align='center'>   
                                <td><a href=viagem_detalhes.php?id=". $row["id"] ."><img  width='50%' src='".$row['caminho_foto']."' alt='imagem da viagem'></a></td>
                                <td width='50%' align='left'>Viagem para ".$row['destino']." com estadia de ".$row['diarias']." dias.</td>
                            </tr>
                    ";
                }
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