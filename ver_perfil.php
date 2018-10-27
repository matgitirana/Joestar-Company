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

    $sql="select * from Usuario where login = '".$_SESSION["usuario_sessao"]."';";
    $sqlResult = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sqlResult);
    
    $sexo = $consulta["sexo"];
    
    $f ="";
    $m ="";
    $o="";
    
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
				<li><a href='home.php'>Home</a></li>
				<li><a href='login.php'>Login</a></li>				
			</ul>
        </div>

        <?php

        echo "
        	<form action='alterar_usuario2.php' method='post' enctype='multipart/form-data'>
			<table align='center' border='0' width =35%>


				<tr>
					<td><label>Nome</label></td>
					<td><input type='text' size='30' name='nome' maxlength='50' value='". $consulta['nome'] ."' readonly='readonly'></td>
				</tr>	
				
				<tr>
					<td><label>Sobrenome</label></td>
					<td><input type='text' size='30' name='sobrenome' maxlength='50' value='". $consulta['sobrenome'] ."' readonly='readonly'></td>
				</tr>

				<tr>
					<td><label>Data de nascimento</label></td>
					<td><input type='date' size='30' name='data_nascimento' maxlength='50' value='". $consulta['data_nascimento'] ."' readonly='readonly'></td>
				</tr>

				<tr>
					<td><label>Endereço</label></td>
					<td><input type='text' size='30' name='endereco' maxlength='50' value='". $consulta['endereco'] ."' readonly='readonly'></td>
				</tr>

				<tr>
					<td><label>Telefone</label></td>
					<td><input type='text' size='30' name='telefone' maxlength='20' value='". $consulta['telefone'] ."' readonly='readonly'></td>
				</tr>
				
				<tr>
					<td><label>Sexo</label>
                    <td>
                    <input type='text' size='30' name='telefone' maxlength='20' value='". $consulta['sexo'] ."'readonly='readonly'>
                    
						
					</td>
				</tr>
				
				<tr>
					<td><label>RG</label></td>
					<td><input type='text' size='30' name='rg' maxlength='30' value='". $consulta['rg'] ."' readonly='readonly'></td>
				</tr>

				<tr>
					<td><label>CPF</label></td>
					<td><input type='text' size='30' name='cpf' maxlength='11' minlength='11' value='". $consulta['cpf'] ."' readonly='readonly'></td>
				</tr>
				
				
				
				<tr>
					<td><label>Login</label></td>
					<td><input type='text' size='30' name='usuario' maxlength='10' value='". $consulta['login'] ."' readonly='readonly'></td>
				</tr>
				
				<tr>
					<td><label>Senha</label></td>
					<td><input type='password' size='30' name='senha' minlength='5' maxlength='20' value='". $consulta['senha'] ."' readonly='readonly'></td>
                </tr>
                <tr>
					<td><label>Foto</label></td>
					<td><img src='".$consulta['caminho_foto']."' alt='foto de perfil' width='50%'></td>
				</tr>
				
				<tr>
					<td align='right' >
						<a href=alterar_usuario>Editar perfil</a>
                    </td>
                    <td align='center'>
						<a href=deletar_usuario>Excluir perfil</a>
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
