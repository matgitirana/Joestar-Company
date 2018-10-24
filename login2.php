<?php
	session_start();
	if(!isset($_SESSION['usuario_sessao'])){
        $_SESSION["usuario_sessao"] = "";
        $_SESSION["tipo_usuario"] = "";
        $_SESSION["compra"] = "";
    }
    
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
    $sql = "select senha, status, tipo from Pessoa where login='".$usuario."';";
	$sqlResultado = $conn->query($sql);
	$consulta = mysqli_fetch_assoc($sqlResultado);
	if($consulta["senha"]!=$senha || $consulta["status"]!='1'){
		$login_valido=false;
	}
    

    //redirect to home    
    if($login_valido){
        $_SESSION["usuario_sessao"] = $usuario;
        $_SESSION["tipo_usuario"] = $consulta["tipo"];
        header("Location: home.php");
        
    //go back to login page        
    } else{
        header("Location: login.php"); /* Redirect browser */
        exit();
    }
?>
