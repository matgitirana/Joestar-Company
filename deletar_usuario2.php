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

    //ID do usuário
    $id = $_POST['id'];
    
    //Status 0 = inativo
    $sql = "update Usuario set status= '0' where  id='".$id."';";
    $sqlResult = mysqli_query($conn,$sql);
    //Se o usuário excluído for o que estava logado, desloga
    if($id==$_SESSION["usuario_id"]){
        header("Location: logout.php");
    }
    else{
        header("Location: home.php");
    }
?>
