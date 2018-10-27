<?php
    session_start();
	if(!isset($_SESSION['usuario_sessao'])){
		$_SESSION["usuario_sessao"] = "";
		$_SESSION["tipo_usuario"] = "";
    }  

    //database information
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

    
	$id = $_GET['id'];
	

    $sql="select * from Viagem where id = '".$id."';";
    $sqlResult = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sqlResult);
    
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
					<td><label>Diárias</label></td>
					<td><input type='text' size='30' name='diarias' maxlength='50' value='". $consulta['diarias'] ."' disabled></td>
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
					<td><label>Hospedagem</label>
                    <td>
                    <input type='text' size='30' name='hospedagem' maxlength='20' value='". $consulta['hospedagem'] ."'disabled>
                    
						
					</td>
				</tr>
				
				<tr>
					<td><label>Passeios</label></td>
                    <td>
                    <textarea textarea name='passeios' rows='4' cols='30' maxlength='200' disabled>". $consulta['passeios'] ."</textarea>>

                    </td>
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
        ?>

		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>
</html>
