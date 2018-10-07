<?php
    session_start();
	if(!isset($_SESSION['usuario_sessao'])){
		$_SESSION["usuario_sessao"] = "";
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
                <li><a href='home.php'>Home</a></li>
                <li><a href='logout.php'>Logout</a></li>
			</ul>
        </div>

        <div>
        	<form action="viagem_dos_sonhos2.php" method="post">

    
					<!-- <label>Destino</label>
					<input type="text" size="30" name="usuario" maxlength="15">
				
					<label>Data</label>
					<input type="date" size="30" name="data">

                    <label>Diárias</label>
					<input type="number" size="30" name="senha"maxlength="30">

                    <label>Tipo de transporte</label>
					<input type="password" size="30" name="senha" minlength="8" maxlength="30">
				
                    <label>Translado</label>
					<input type="password" size="30" name="senha" minlength="8" maxlength="30">

                    <label>Hospedagem</label>
					<input type="password" size="30" name="senha" minlength="8" maxlength="30">

                    <label>Passeios</label>
					<input type="password" size="30" name="senha" minlength="8" maxlength="30">

				
					<input type="submit" value="Enviar"> -->
				
			
			
		    </form>

        </div>


		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>

</html>