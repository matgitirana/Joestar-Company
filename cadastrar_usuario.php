<?php
    session_start();
    if(!isset($_SESSION['usuario_id']))
        $_SESSION['usuario_id'] = '';
    if(!isset($_SESSION['tipo_usuario']))
		$_SESSION["tipo_usuario"] = "";
	if(!isset($_SESSION['mensagem']))
		$_SESSION['mensagem'] = '';		
	if($_SESSION['usuario_id']!='' && $_SESSION['tipo_usuario']=='cliente'){
		header("Location: home.php");
	}
?>

<html>
    <head>
        <title> Agência de Viagens - Cadastro </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="estilo.css" type="text/css" />
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

        	<form action="cadastrar_usuario2.php" method="post" enctype='multipart/form-data'>
			<table align="center" border="0" width =30%>

				<tr>
					<td><label>Nome</label></td>
					<td><input type="text" size="30" name="nome" maxlength="50"></td>
				</tr>	
				
				<tr>
					<td><label>Sobrenome</label></td>
					<td><input type="text" size="30" name="sobrenome" maxlength="50"></td>
				</tr>

				<tr>
					<td><label>Data de nascimento</label></td>
					<td><input type="date" size="30" name="data_nascimento" maxlength="50"></td>
				</tr>

				<tr>
					<td><label>Endereço</label></td>
					<td><input type="text" size="30" name="endereco" maxlength="50"></td>
				</tr>

				<tr>
					<td><label>Telefone</label></td>
					<td><input type="text" size="30" name="telefone" maxlength="20"></td>
				</tr>
				
				<tr>
					<td><label>Sexo</label>
					<td>
						<input type= "radio" name = "sexo" value = "m"/> Masculino
						<input type= "radio" name = "sexo" value = "f"/> Feminino
						<input type= "radio" name = "sexo" value = "o" checked="checked"/> Outro
					</td>
				</tr>
				
				<tr>
					<td><label>RG</label></td>
					<td><input type="text" size="30" name="rg" maxlength="30"></td>
				</tr>

				<tr>
					<td><label>CPF</label></td>
					<td><input type="text" size="30" name="cpf" maxlength="11" minlength="11"></td>
				</tr>
				
				<tr>
					<td><label>Foto</label></td>
					<td><input type="file" name="foto"></td>
				</tr>
				
				<tr>
					<td><label>Login</label></td>
					<td><input type="text" size="30" name="usuario" maxlength="10"></td>
				</tr>
				
				<tr>
					<td><label>Senha</label></td>
					<td><input type="password" size="30" name="senha" minlength="5" maxlength="20" ></td>
				</tr>
				
				<tr>
					<td align="center" colspan="2">
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
