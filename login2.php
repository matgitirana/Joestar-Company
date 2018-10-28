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
    
    //Entrada do usuário
	$usuario=$_POST['usuario'];
    $senha=$_POST['senha'];
    //Valida login
    $login_valido = true;		
    $sql = "select id, senha, status, tipo from Usuario where login='".$usuario."';";
	$sqlResultado = $conn->query($sql);
	$consulta = mysqli_fetch_assoc($sqlResultado);
	if($consulta["senha"]!=$senha || $consulta["status"]!='1'){
		$login_valido=false;
	}
    
    if($login_valido){
        $_SESSION["usuario_id"] = $consulta['id'];
		$_SESSION["tipo_usuario"] = $consulta["tipo"];
    	header("Location: home.php");
             
    } else{
        header("Location: login.php"); 
        exit();
    }
?>
