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
?>

<html>

<head>
	<title> Agência de Viagens - Viagem dos Sonhos </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="estilo.css" type="text/css" />
	<!--
	Habilita registro de preço de diária se for selecionado que aquela viagem terá aquele nível de hotel
	Habilita registro de preço de translado se for selecionado que o translado será pago
	-->
	<script>
		function translado_input(){
			var radios = document.getElementsByName('translado');
			var input = document.getElementsByName('preco_translado')[0];
			for (var i = 0, length = radios.length; i < length; i++){
				if (radios[i].checked && radios[i].value=='true'){
					input.disabled = false;
				} else if(radios[i].checked && radios[i].value=='false'){
					input.value = '';
					input.disabled = true;
				}
			}
		}

		function hospedagem_input(i) {
			var checkBox = document.getElementsByName('hospedagem'+i)[0];
			var input = document.getElementsByName('preco_diaria'+i)[0];
			if (checkBox.checked == true){
				input.disabled = false;
			} else {
				input.value = '';
				input.disabled = true;
			}
		}
		
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
						<li><a href='consulta_compras.php'>Compras</a></li>
                        <li><a href='logout.php'>Logout</a></li>
                        ";
                    } else if($_SESSION['tipo_usuario'] == 'adm'){
                        echo "
                        <li><a href='home.php'>Home</a></li>
                        <li><a href='consultar_viagens.php'>Viagens</a></li>
						<li><a href='ver_perfil.php'>Perfil</a></li>
						<li><a href='consulta_compras.php'>Compras</a></li>
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
	echo "
		<form action='cadastrar_viagem2.php' method='post' enctype='multipart/form-data'>
			<table align='center' border='0' width=50%>

				<tr>
					<td><label>Destino</label></td>
					<td><input type='text' size='30' name='destino' maxlength='30'></td>
				</tr>

				<tr>
					<td><label>Data de partida</label></td>
					<td>
						<input type='date' size='30' name='data_partida'>
					</td>
				</tr>

				<tr>
					<td><label>Tipo de transporte</label></td>
					<td>
						<select name='transporte'>
						";
							//seleciona e mostra os transportes cadastrados no banco
							$sql = 'select transporte from Transporte;';
							$sql_resultado = mysqli_query($conn,$sql);
							if(mysqli_num_rows($sql_resultado)>0){
								while($transporte = mysqli_fetch_assoc($sql_resultado)){
									echo"'<option value=".$transporte['transporte'].">".$transporte['transporte']."</option>'";
								}
							}
						echo"
						</select>
					</td>
				</tr>
				<tr>

					<td><label>Translado</label></td>
					<td>
						<input type='radio' name='translado' value=true onclick='translado_input()'>Sim
						<input type='radio' name='translado' value=false checked='checked' onclick='translado_input()'>Não
					</td>
				</tr>

				<tr>
					<td><label>Preço do translado</label></td>
					<td>
						<input type='number' size='30' name='preco_translado' step='0.01' disabled>
					</td>
				</tr>

				<tr>
					<td><label>Hospedagem</label></td>
					<td>
						<input type='checkbox' name='hospedagem1' value='1' onclick='hospedagem_input(1)'>1 estrela
						<input type='checkbox' name='hospedagem2' value='2' onclick='hospedagem_input(2)'>2 estrelas
						<input type='checkbox' name='hospedagem3' value='3' onclick='hospedagem_input(3)'>3 estrelas<br>
						<input type='checkbox' name='hospedagem4' value='4' onclick='hospedagem_input(4)'>4 estrelas
						<input type='checkbox' name='hospedagem5' value='5' onclick='hospedagem_input(5)'>5 estrelas
					</td>
				</tr>

				<tr>
					<td><label>Preço da diária</label></td>
					<td>
						<input placeholder='hotel 1 estrela' type='number' size='30' name='preco_diaria1' step='0.01' disabled><br>
					
						<input placeholder='hotel 2 estrelas' type='number' size='30' name='preco_diaria2' step='0.01' disabled><br>
					
						<input placeholder='hotel 3 estrelas' type='number' size='30' name='preco_diaria3' step='0.01' disabled><br>
					
						<input placeholder='hotel 4 estrelas' type='number' size='30' name='preco_diaria4' step='0.01' disabled><br>
					
						<input placeholder='hotel 5 estrelas' type='number' size='30' name='preco_diaria5' step='0.01' disabled>
					</td>
				</tr>

				<tr>
						<td><label>Foto</label></td>
						<td><input type='file' name='foto'></td>
					</tr>

				<tr>
					<td colspan=2 align='center'>
						<input type='submit' value='Enviar'>
					</td>
				</tr>
			</table>
		</form>
	
	
	";
}





?>
	

	<div id='rodape'>
		<footer>
			Agênica de Viagens - 2018
		</footer>
	</div>

</body>

</html>