<?php
    session_start();
    if(!isset($_SESSION['usuario_id']))
        $_SESSION['usuario_id'] = '';
    if(!isset($_SESSION['tipo_usuario']))
        $_SESSION["tipo_usuario"] = "";

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

    if($_SESSION["tipo_usuario"] = "cliente"){
		$usuario_id = $_SESSION["usuario_id"];
	} else if($_SESSION["tipo_usuario"] = "admin"){
		$usuario_id = $_GET['id'];
	}

    $sql="select * from Usuario where id = '". $usuario_id ."';";
    $sqlResult = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sqlResult);
    
    $sexo = $consulta["sexo"];
    
    if($consulta["sexo"] == "f"){
        $consulta["sexo"] = "feminino";
    } else if($consulta["sexo"] == "m"){
        $consulta["sexo"] = "masculino";
    } else {
        $consulta["sexo"] = 'Outro';
    }    
    
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
        	<form action='deletar_usuario2.php' method='post' enctype='multipart/form-data'>
			<table align='center' border='0' width =35%>

                <tr>
                    <td colspan='2' align='center'><h2>Você quer mesmo excluir esse perfil?</h2></td>
                </tr>

				<tr>
					<td><label>Nome</label></td>
					<td><input type='text' size='30' name='nome' maxlength='50' value='". $consulta['nome'] ."' disabled></td>
				</tr>	
				
				<tr>
					<td><label>Sobrenome</label></td>
					<td><input type='text' size='30' name='sobrenome' maxlength='50' value='". $consulta['sobrenome'] ."' disabled></td>
				</tr>

				<tr>
					<td><label>Data de nascimento</label></td>
					<td><input type='date' size='30' name='data_nascimento' maxlength='50' value='". $consulta['data_nascimento'] ."' disabled></td>
				</tr>

				<tr>
					<td><label>Endereço</label></td>
					<td><input type='text' size='30' name='endereco' maxlength='50' value='". $consulta['endereco'] ."' disabled></td>
				</tr>

				<tr>
					<td><label>Telefone</label></td>
					<td><input type='text' size='30' name='telefone' maxlength='20' value='". $consulta['telefone'] ."' disabled></td>
				</tr>
				
				<tr>
					<td><label>Sexo</label>
                    <td>
                    <input type='text' size='30' name='telefone' maxlength='20' value='". $consulta['sexo'] ."'disabled>
                    
						
					</td>
				</tr>
				
				<tr>
					<td><label>RG</label></td>
					<td><input type='text' size='30' name='rg' maxlength='30' value='". $consulta['rg'] ."' disabled></td>
				</tr>

				<tr>
					<td><label>CPF</label></td>
					<td><input type='text' size='30' name='cpf' maxlength='11' minlength='11' value='". $consulta['cpf'] ."' disabled></td>
				</tr>
				
				<input type='hidden' name='id' value=". $consulta['id'] .">
				
				<tr>
					<td><label>Login</label></td>
					<td><input type='text' size='30' name='usuario' maxlength='10' value='". $consulta['login'] ."' disabled></td>
				</tr>
				
				<tr>
					<td><label>Senha</label></td>
					<td><input type='password' size='30' name='senha' minlength='5' maxlength='20' value='". $consulta['senha'] ."' disabled></td>
                </tr>
                <tr>
					<td><label>Foto</label></td>
					<td><img src='".$consulta['caminho_foto']."' alt='foto de perfil' width='50%'></td>
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
