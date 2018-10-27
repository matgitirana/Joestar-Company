<?php
	session_start();
    
	//database information
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
    
    //user input
	$usuario=$_POST['usuario'];
    $senha=$_POST['senha'];
    //check login
    $login_valido = true;		
    $sql = "select id, senha, status, tipo from Usuario where login='".$usuario."';";
	$sqlResultado = $conn->query($sql);
	$consulta = mysqli_fetch_assoc($sqlResultado);
	if($consulta["senha"]!=$senha || $consulta["status"]!='1'){
		$login_valido=false;
	}
    

    //redirect to home    
    if($login_valido){
        $_SESSION["usuario_id"] = $consulta['id'];
		$_SESSION["tipo_usuario"] = $consulta["tipo"];
    	header("Location: home.php");
             
    } else{
        header("Location: login.php"); 
        exit();
    }
?>
