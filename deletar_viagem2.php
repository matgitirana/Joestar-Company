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
    $id = $_POST['id'];
    
    
    $sql = "update Viagem set status= '0' where  id=".$id.";";
    $sqlResult = mysqli_query($conn,$sql);
    
    header("Location: home.php");
    
?>
