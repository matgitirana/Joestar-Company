<?php
	session_start();

    //Informações do banco de dados
    $servername = "localhost";
	$username = "root";
	$password = "123456";
	$dbname = "JoestarCompany";

	//Cria conexão com o banco
	$conn = new mysqli($servername, $username, $password, $dbname);

	//Checa conexão com o banco
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	//ID da viagem
    $id = $_POST['id'];
    
    //Status 0 = inativo
    $sql = "update Viagem set status= '0' where  id=".$id.";";
    $sqlResult = mysqli_query($conn,$sql);
    
    header("Location: home.php");
    
?>
