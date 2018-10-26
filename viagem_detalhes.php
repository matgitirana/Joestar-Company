<?php
    session_start();
    if(!isset($_SESSION['usuario_sessao'])){
        $_SESSION['usuario_sessao'] = '';
        $_SESSION["tipo_usuario"] = "";
    }

    //falta deixar o cliente enviar uma sugestão ou dúvida

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
    $id = $_GET["id"];

    //seleciona todas as viagens que não são viagem dos sonhos
    $sql="select * from Viagem where id=$id;";
    $sqlResult = $conn->query($sql);

    
    
    $preco = 0;
?>

<html>
    <head>
        <title> Agência de Viagens - Detalhe da viagem </title>
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

        <?php
        if($sqlResult->num_rows>0){
            $viagem = $sqlResult->fetch_assoc();
                if($viagem["status"]=='1'){
                    //preço do transporte
            $sql="select preco from Transporte where transporte='". $viagem["transporte"] ."';";
            $preco_select = $conn->query($sql);
            $preco_transporte = $preco_select->fetch_assoc();
            //calcula preço
            $preco = $viagem["diarias"]*$viagem["preco_diaria"]+$preco_transporte["preco"]+$viagem["preco_translado"];
            echo "

            <td width=70% valign='top'>
            <form action='comprar_viagem.php' method='post'>
                <table align='center' border='0' width =100%>
                    <tr  align='center'>   
                        <td colspan='3' ><h1>Detalhes da viagem</h1></td>
                    </tr>
                    <tr>
                    <td colspan='2'><input type='hidden' name='id' value='". $viagem["id"]."'</td>
                    </tr>
                    <tr>
                        <th>Destino</th>
                        <td>".$viagem['destino']."</td>
                        <td rowspan='10'><img src='".$viagem['caminho_foto']."' alt='imagem da viagem'></td>
                    </tr>
                    <tr>
                        <th> Data de partida</th>
                        <td>".$viagem['data_partida']."</td>
                    </tr>
                    <tr>
                        <th> Número de diárias</th>
                        <td>".$viagem['diarias']."</td>
                    </tr>
                    <tr>
                        <th> Modo de transporte</th>
                        <td>".$viagem['transporte']."</td>
                    </tr>
                    <tr>
                        <th> Tipo de Hotel</th>
                        <td>".$viagem['hospedagem']." estrelas</td>
                    </tr>
                    <tr>
                        <th> Passeios</th>
                        <td>".$viagem['passeios']."</td>
                    </tr>
                    <tr>
                        <th> Preço</th>
                        <td>".$preco."</td>
                    </tr>
                    
                    <tr>
                        <td colspan='2' align='center'><input type='submit' value='Comprar'></td>
                    </tr>
                    
                    
                    
                    </table>
                    </form>
                </td>
            </tr>
        </table>
                    ";
                }
            
        } else{
            echo "Viagem inexistente";
        }
        ?>
        
            

		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>
</html>