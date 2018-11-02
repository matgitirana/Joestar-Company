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
	$id = $_GET['id'];
	
    //Informações da viagem
    $sql="select * from Viagem where id = ".$id." and status = 1;";
    $sql_resultado = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sql_resultado);
    
?>

<html>
    <head>
        <title> Agência de Viagens - Cadastro </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="estilo.css" type="text/css" />
    </head>

    <body>

        <div id="topo">
            <ul id="menu">
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

        <?php
        if($_SESSION['tipo_usuario']=='adm'){
            if(mysqli_num_rows($sql_resultado)>0){
                //Mostra todas as informações da viagem e não deixa usuário editar
                echo "
                    <form action='deletar_viagem2.php' method='post' enctype='multipart/form-data'>
                    <table align='center' border='0' width =35%>
    
                        <tr>
                            <td colspan='2' align='center'><h2>Você quer mesmo excluir essa viagem?</h2></td>
                        </tr>
    
                        <input type='hidden' name='id' value='".$id."'>
    
                        <tr>
                            <td><label>Destino</label></td>
                            <td><input disabled type='text' size='30' name='destino' maxlength='50' value='". $consulta['destino'] ."' ></td>
                        </tr>	
                        
                        <tr>
                            <td><label>Data de partida</label></td>
                            <td><input type='date' size='30' name='data_partida' maxlength='50' value='". $consulta['data_partida'] ."' disabled></td>
                        </tr>
    
                        <tr>
                            <td><label>Modo de transporte</label></td>
                            <td><input type='text' size='30' name='transporte' maxlength='50' value='". $consulta['transporte'] ."' disabled></td>
                        </tr>
    
                        <tr>
                            <td><label>Translado</label></td>
                            <td><input type='text' size='30' name='translado' maxlength='20' value='". $consulta['translado'] ."' disabled></td>
                        </tr>
    
                        <tr>
                            <td><label>Foto</label></td>
                            <td><img src='".$consulta['caminho_foto']."' alt='foto da viagem' width='50%'></td>
                        </tr>
                        
                        <tr>
                            <td align='center' colspan='2'>
                                <input type='submit' value='Excluir'>
                            </td>
                            
                        </tr>
                        
                        
                    </table>
                    </form>
                ";
            } else {
                echo "Essa viagem não existe";
            }
    
        } else{
            echo"Você não tem acesso a essa página";
        }
        
        ?>

		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>
</html>
