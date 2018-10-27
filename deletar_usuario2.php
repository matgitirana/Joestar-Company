<?php
	session_start();
	if(!isset($_SESSION['usuario_sessao'])){
		$_SESSION["usuario_sessao"] = "";
		$_SESSION["tipo_usuario"] = "";
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
    $usuario = $_POST['usuario'];
    
    
    $sql = "update Usuario set status= '0' where  login='".$usuario."';";
    $sqlResult = mysqli_query($conn,$sql);
    if($usuario==$_SESSION["usuario_sessao"]){
        header("Location: logout.php");
    }
    else{
        header("Location: home.php");
    }
?>
