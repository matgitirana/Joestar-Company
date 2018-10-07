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
        	
			<div style="list-style: none; text-align: center;">
				<form action="login2.php" method="post">
				<li><label>Login</label>
				<input type="text" size="30" name="usuario" maxlength="15"></li>
				<li><label>Senha</label>
				<input type="password" size="30" name="senha" minlength="8" maxlength="30"></li>
				<li><input type="submit" value="Enviar"></li>
				<li><p>Não possui cadastro? Clique <a href='cadastro.php'>aqui</a></p></li>
				</form>
			</div>
			

        </div>


		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>

</html>