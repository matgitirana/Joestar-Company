<?php
    session_start();
    if(!isset($_SESSION['usuario_id']))
        $_SESSION['usuario_id'] = '';
    if(!isset($_SESSION['tipo_usuario']))
		$_SESSION["tipo_usuario"] = "";
	
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
?>

<html>

<head>
	<title> Agência de Viagens - Viagem dos Sonhos </title>
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

	<form action="cadastrar_viagem2.php" method="post" enctype='multipart/form-data'>
		<table align="center" border="0" widtd=50%>

			<tr>
				<td><label>Destino</label></td>
				<td><input type="text" size="30" name="destino" maxlength="30"></td>
			</tr>

			<tr>
				<td><label>Data de partida</label></td>
				<td>
					<input type="date" size="30" name="data_partida">
				</td>
			</tr>
			<tr>
				<td><label>Diárias</label></td>
				<td>
					<input type="number" size="30" name="diarias" maxlengtd="2">
				</td>
			</tr>

            <tr>
				<td><label>Preço da diária</label></td>
				<td>
					<input type="number" size="30" name="preco_diaria" step="0.01">
				</td>
			</tr>

			<tr>
				<td><label>Tipo de transporte</label></td>
				<td>
					<select name='transporte'>
                    <?php
                        $sql = 'select transporte from Transporte;';
                        $sqlResult = $conn->query($sql);
                        if($sqlResult->num_rows>0){
                            while($transporte = $sqlResult->fetch_assoc()){
                                echo"<option value='".$transporte['transporte']."'>".$transporte['transporte']."</option>";
                            }
                        }
                    ?>
					</select>
				</td>
			</tr>
			<tr>

				<td><label>Translado</label></td>
				<td>
					<input type="radio" name="translado" value=Sim>Sim
					<input type="radio" name="translado" value=Não checked="checked">Não
				</td>
			</tr>

            <tr>
				<td><label>Preço do translado</label></td>
				<td>
					<input type="number" size="30" name="preco_translado" step="0.01">
				</td>
			</tr>

			<tr>
				<td><label>Hospedagem</label></td>
				<td>
					<select name='hospedagem'>
						<option value="1">1 estrela</option>
						<option value="2">2 estrelas</option>
						<option value="3">3 estrelas</option>
						<option value="4">4 estrelas</option>
						<option value="5">5 estrelas</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td><label>Passeios</label></td>
				<td>
					<textarea textarea name='passeios' rows='4' cols='30' maxlength='200' placeholder='Descreva sobre os passeios aqui'></textarea>>
				</td>
			</tr>

            <tr>
					<td><label>Foto</label></td>
					<td><input type="file" name="foto"></td>
				</tr>

			<tr>
				<td colspan=2 align="center">
					<input type="submit" value="Enviar">
				</td>
			</tr>
		</table>
	</form>

	<div id='rodape'>
		<footer>
			Agênica de Viagens - 2018
		</footer>
	</div>

</body>

</html>