<?php
    session_start();
    if(!isset($_SESSION['usuario_id']))
        $_SESSION['usuario_id'] = '';
    if(!isset($_SESSION['tipo_usuario']))
        $_SESSION["tipo_usuario"] = "";
    

    $servername = "localhost";
	$username = "root";
	$password = "123456";
	$dbname = "JoestarCompany";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
    }
    $usuario_id = $_SESSION["usuario_id"];
    $texto = $_POST['texto'];
    $viagem_id = $_POST['viagem_id'];
    if(strlen($texto)>0){
        $sql = "insert into Comentario(id_viagem, id_usuario, texto) values (".$viagem_id.", ".$usuario_id.", '".$texto."');";
    }

    header("Location: login.php?id=".$viagem_id."");
?>