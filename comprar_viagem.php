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

    //ID da viagem
    $id = $_POST["id"];

    //seleciona todas as informações dessa viagem
    $sql="select * from Viagem where id=$id and disponibilidade='1';";
    $sql_resultado = mysqli_query($conn,$sql);
?>

<html>
    <head>
        <title>Página de compra </title>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<link rel='stylesheet' href='estilo.css' type='text/css' />
        <script>
            function mostrar_erro(){
                var mensagem_erro = "<?php echo $_SESSION['mensagem'] ?>";
                if(mensagem_erro!=''){
                    alert(mensagem_erro);
                    <?php $_SESSION['mensagem'] = ''; ?>
                }
            }
        </script>
    </head>

    <body onload='mostrar_erro()'>
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

        <?php
        //Mostra todas as informações da viagem se ela existir
        if(mysqli_num_rows($sql_resultado)>0){
            $viagem = mysqli_fetch_assoc($sql_resultado);
            //Busca preço do transporte no banco
            $sql="select preco from Transporte where transporte='". $viagem["transporte"] ."';";
            $preco_select = mysqli_query($conn,$sql);
            $preco_transporte = mysqli_fetch_assoc($preco_select);
            //Calcula preço
            $preco = $preco_transporte["preco"]+$viagem["preco_translado"];
            //Hospedagens disponíveis para a viagem
            $sql="select estrelas from Hospedagem where id_viagem=". $viagem["id"] .";";
            $hospedagem_select = mysqli_query($conn,$sql);
            $i = 0;
            while($hospedagem_estrela = mysqli_fetch_assoc($hospedagem_select)){
                $hospedagem[$i] = $hospedagem_estrela['estrelas'];
                $i++;
            }
            //Passeios disponíveis para a viagem
            $sql="select * from Passeio where id_viagem=". $viagem["id"] .";";
            $passeio_select = mysqli_query($conn,$sql);
            echo "

            <td width=70% valign='top'>
            <form action='' method='post'>
                <table align='center' border='0' width =100%>
                    <tr  align='center'>   
                        <td colspan='3' ><h1>Página de compra</h1></td>
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
                        <th> Modo de transporte</th>
                        <td>".$viagem['transporte']."</td>
                    </tr>
                    <tr>
                        <th> Preço</th>
                        <td>".$preco."</td>
                    </tr>
                    <tr>
                        <th> Opções de hospedagem</th>
                        <td>
                    ";
                    for($i = 0; $i < count($hospedagem); $i++) {
                        echo
                        "<input type='radio' name='hospedagem' value='$hospedagem[$i]'> ".$hospedagem[$i]." estrelas";
                    }
                    echo "</td></tr>
                    <tr>
                        <th> Passeios disponíveis</th>
                        <td>";
                    if(mysqli_num_rows($passeio_select)>0){
                        $i = 0;
                        while($passeio = mysqli_fetch_assoc($passeio_select)){
                            echo
                            "<input type='checkbox' name='passeio".$i."' value='$passeio[id]'>".$passeio['descricao']."  R$:".$passeio['preco']."<br>";
                            $i++;
                        }
                    }
                    echo"
                    </td>
                    </tr>
                    <tr>
                        <td colspan='2' align='center'></td>
                    </tr>
                    
                    <tr>
                        <th>Forma de pagamento</th>
                        <td>
                            <select name='pagamento'>
                                <option value='cartao'>Cartão de crédito</option>
                                <option value='boleto'>Boleto</option>
                                <option value='paypal'>Paypal</option>
                            </select>
                        </td>
                    </tr>
                </table>
                </form>
            </td>
        </tr>";

            
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