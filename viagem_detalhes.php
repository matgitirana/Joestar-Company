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
    $id = $_GET["id"];

    //seleciona todas as informações dessa viagem
    $sql="select * from Viagem where id=$id and disponibilidade='1';";
    $sql_resultado = mysqli_query($conn,$sql);
?>

<html>
    <head>
        <title> Agência de Viagens - Detalhe da viagem </title>
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
            $hospedagem = "";
            $sql="select estrelas from Hospedagem where id_viagem=". $viagem["id"] .";";
            $hospedagem_select = mysqli_query($conn,$sql);
            while($hospedagem_estrela = mysqli_fetch_assoc($hospedagem_select)){
                $hospedagem = $hospedagem . $hospedagem_estrela['estrelas'] . " estrelas. ";
            }
            //Passeios disponíveis para a viagem
            $passeios = "";
            $sql="select descricao from Passeio where id_viagem=". $viagem["id"] .";";
            $passeio_select = mysqli_query($conn,$sql);
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
                        <td rowspan='10'><img src='".$viagem['caminho_foto']."' alt='imagem da viagem' width = '300px'></td>
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
                        <td>R$ ".$preco."</td>
                    </tr>
                    <tr>
                        <th> Opções de hospedagem</th>
                        <td>".$hospedagem."</td>
                    </tr>
                    ";
                    if(mysqli_num_rows($passeio_select)>0){
                        while($passeio_descricao = mysqli_fetch_assoc($passeio_select)){
                            $passeios = $passeios . "- ". $passeio_descricao['descricao'] . ".<br> ";
                        }
                        echo
                            "<tr>
                                <th> Passeios disponíveis</th>
                                <td>".$passeios."</td>
                            </tr>";
                    }
                    if($_SESSION['usuario_id'] != '') {
                        echo "
                            <tr>
                                <td colspan='2' align='center'><input type='submit' value='Comprar'></td>
                            </tr>";
                    }
                    echo "
                    
                    
                    
                </table>
                </form>
            </td>
        </tr>";

            //Se existirem comentários sobre a viagem feita por usuários ainda ativos, mostra
            $sql = "select u.login as usuario, c.texto as texto from Comentario as c, Usuario as u where c.id_usuario = u.id and c.id_viagem = ".$id." and u.disponibilidade='1';";
            $comentarioResult = mysqli_query($conn,$sql);
            if(mysqli_num_rows($comentarioResult)>0){
                echo"
                <tr>
                    <td colspan='2' align='center'> <h2>Comentários</h2></td>
                </tr>
                <tr>
                <td width=30% valign='top'>
                <table align='center' border='0' width =50%>
                <tr>
                <th>Usuário</th>
                <th>Comentário</th>
                </tr>
                ";

                while( $comentario = mysqli_fetch_assoc($comentarioResult)){
                    echo"
                        <tr>
                            <td align='center'>". $comentario["usuario"] .": </td>
                            <td align='center'>". $comentario["texto"] ."</td>
                        </tr>"
                    ;
                }
            }
            //Se usuário for cliente, opção de escrever um comentário sobre a viagem
            if($_SESSION["tipo_usuario"]=="cliente"){
                echo"
                <form action='criar_comentario.php' method='post'>
                <tr>
                    <td align='center' colspan='2'>Gostaria de deixar uma sugestão ou uma dúvida?</td>
                </tr>

                <input type='hidden' name='viagem_id' value='".$id."'>

                <tr>
                    <td align='center' colspan='2'><textarea name='texto' rows='4' cols='30' maxlength='500' placeholder='Escreva seu texto aqui'></textarea></td>
                </tr>
                <tr>
                    <td align='center' colspan='2'><input type='submit' value='Enviar'></td>
                </tr>
                </form>
                ";
            }
            echo"
            </table>
            </td>
                </tr>

            </table>
            ";
                        
            
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