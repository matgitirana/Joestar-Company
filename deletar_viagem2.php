<?php
	session_start();

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
	//ID da viagem
    $id = $_POST['id'];
    
    //disponibilidade 0 = inativo
    $sql = "update Viagem set disponibilidade= '0' where  id=".$id.";";
    $sql_resultado = mysqli_query($conn,$sql);
    
    header("Location: consultar_viagens.php");
    
?>
