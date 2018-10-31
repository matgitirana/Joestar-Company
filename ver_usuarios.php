<?php
    session_start();
    if(!isset($_SESSION['usuario_id']))
        $_SESSION['usuario_id'] = '';
    if(!isset($_SESSION['tipo_usuario']))
        $_SESSION["tipo_usuario"] = "";

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

	//Seleciona usuários ativos
    $sql="select * from Usuario where disponibilidade='1';";
	$sql_resultado = mysqli_query($conn,$sql);
	
	//Função para colocar a string correta do sexo
	function sexo_string($sexo){
		if($sexo == "f"){
			$sexo = "feminino";
		} else if($sexo == "m"){
			$sexo = "masculino";
		} else {
			$sexo = 'Outro';
		}
		return $sexo;
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

		//Mostra todas as informações de todos os usuários ativos
        echo "
			<table align='center' border='0' width =100%>

				<tr>
					<td colspan='12' align='center'><h1>Usuários cadastrados</h1></td>
				</tr>
				<tr>
					<th>Nome</th>
					<th>Sobrenome</th>
					<th>Data de nascimento</th>
					<th>RG</th>
					<th>CPF</th>
					<th>Sexo</th>
					<th>Endereço</th>
					<th>Telefone</th>
					<th>Perfil</th>
					<th>Login</th>
					<th>Foto</th>
					<th>Opções</th>
				</tr>
				";
				if(mysqli_num_rows($sql_resultado)>0){
					while($row = mysqli_fetch_assoc($sql_resultado)){
							echo "
                                <tr align='center'>   
                                    <td>".$row["nome"]."</td>
                                    <td>".$row["sobrenome"]."</td>
                                    <td>".$row["data_nascimento"]."</td>
                                    <td>".$row["rg"]."</td>
									<td>".$row["cpf"]."</td>
									<td>".sexo_string($row["sexo"])."</td>
                                    <td>".$row["endereco"]."</td>
                                    <td>".$row["telefone"]."</td>
                                    <td>".$row["tipo"]."</td>
									<td>".$row["login"]."</td>
									<td><img src='".$row["caminho_foto"]."' alt='foto do usuario ".$row["login"]."' width='100px'></td>
									";
									if($row["tipo"]=='cliente'){
										echo"
											<td><a href=deletar_usuario.php?id=". $row["id"] .">Deletar Cliente</td>
										";
									}
								echo"
								</tr>
								
                            ";


						}
				}

				echo "</table>";
			
        
        ?>

		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>
</html>
