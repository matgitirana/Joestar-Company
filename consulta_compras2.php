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

    $id = $_GET['id'];

    $sql='update compra set estado = "Cancelado" where id='.$id.';';
    mysqli_query($conn,$sql);
    header("Location: consulta_compras.php");
?>