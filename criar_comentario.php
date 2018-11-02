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

    //ID do usuário logado, ID da viagem e texto do usuário
    $usuario_id = $_SESSION["usuario_id"];
    $viagem_id = $_POST['viagem_id'];
    $texto = $_POST['texto'];
    //Se tiver texto, insere no banco
    if(strlen($texto)>0){
        $sql = "insert into Comentario(id_viagem, id_usuario, texto) values (".$viagem_id.", ".$usuario_id.", '".$texto."');";
        mysqli_query($conn,$sql);
    } else{
        $_SESSION['mensagem'] = "Comentário inválido";
    }

    header("Location: viagem_detalhes.php?id=".$viagem_id."");
?>