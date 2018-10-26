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
    $sql="select id, destino, data_partida, diarias, transporte, status,preco_diaria, preco_translado from Viagem;";
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
                    //mostra todas as viagens disponíveis
                    if($sqlResult->num_rows>0){
                        while($row = $sqlResult->fetch_assoc()){
                            if($row["status"]=='1'){
                                //preço do transporte
                                $sql="select preco from Transporte where transporte='". $row["transporte"] ."';";
                                $preco_select = $conn->query($sql);
                                $preco_transporte = $preco_select->fetch_assoc();
                                //calcula preço
                                $preco = $row["diarias"]*$row["preco_diaria"]+$preco_transporte["preco"]+$row["preco_translado"];
                                echo "
                                <tr align='center'>   
                                    <td>".$row["destino"]."</td>
                                    <td>".$row["data_partida"]."</td>
                                    <td>".$row["diarias"]."</td>
                                    <td>".$row["transporte"]."</td>
                                    <td>\$$preco</td>
                                    <td><a href=viagem_detalhes.php?id=". $row["id"] .">Detalhes da viagem</td>
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