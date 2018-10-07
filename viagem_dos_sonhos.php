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

	<form action="viagem_dos_sonhos2.php" method="post">
		<table align="center" border="0" widtd=50%>

			<tr>
				<td><label>Destino</label></td>
				<td>
					<select name='destino'>
						<option value="Sao Paulo">Sao Paulo</option>
						<option value="Rio de Janeiro">Rio de Janeiro</option>
						<option value="Londres">Londres</option>
						<option value="Paris">Paris</option>
						<option value="Toquio">Toquio</option>
					</select>
				</td>
			</tr>

			<tr>
				<td><label>Data</label></td>
				<td>
					<input type="date" size="30" name="data">
				</td>
			</tr>
			<tr>
				<td><label>Diárias</label></td>
				<td>
					<input type="number" size="30" name="diarias" maxlengtd="2">
				</td>
			</tr>

			<tr>
				<td><label>Tipo de transporte</label></td>
				<td>
					<select name='transporte'>
						<option value="Trem">Trem</option>
						<option value="Navio">Navio</option>
						<option value="Aviao">Aviao</option>
					</select>
				</td>
			</tr>
			<tr>

				<td><label>Translado</label></td>
				<td>
					<input type="radio" name="translado" value=true>Sim
					<input type="radio" name="translado" value=false checked="checked">Nao
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
					<input type="radio" name="passeios" value=true>Sim
					<input type="radio" name="passeios" value=false checked="checked">Nao
				</td>
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