<?php
    session_start();
	if(!isset($_SESSION['usuario_sessao'])){
		$_SESSION["usuario_sessao"] = "";
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
				<li><a href='login.php'>Login</a></li>
			</ul>
        </div>

        <div>
        	<form action="login2.php" method="post">
			<table align="center" border="0" width =30%>

				<tr>
					<td><label>Login</label></td>
					<td><input type="text" size="30" name="usuario" maxlength="15"></td>
				</tr>
				
				
				<tr>
					<td><label>Senha</label></td>
					<td><input type="password" size="30" name="senha" minlength="8" maxlength="30" ></td>
				</tr>
				
				
				
				<tr>
					<td align="center" colspan="2">
						<input type="submit" value="Enviar">
					</td>
				</tr>
				<tr>
                    <td colspan='2' align='center' valign='middle'>
                        <p>
                            Não possui cadastro? Clique <a href='cadastro.php'>aqui</a>.
                        </p>
                    </td>
                </tr>
				
			
			
			</table>
		    </form>

        </div>


		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>

</html>