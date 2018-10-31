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

    //ID do usuário
    $id = $_POST['id'];
    
    //disponibilidade 0 = inativo
    $sql = "update Usuario set disponibilidade= '0' where  id='".$id."';";
    $sql_resultado = mysqli_query($conn,$sql);
    //Se o usuário excluído for o que estava logado, desloga
    if($id==$_SESSION["usuario_id"]){
        header("Location: logout.php");
    }
    else{
        header("Location: home.php");
    }
?>
