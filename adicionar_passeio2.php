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
	//ID da viagem e entradas do usuário
    $id_viagem = $_POST['id_viagem'];
    $descricao = $_POST['descricao'];
    if(isset($_POST['preco_passeio']))
        $preco = $_POST['preco_passeio'];
    else
        $preco=0;

    $passeio_valido = true;
    
    if(strlen($descricao)==0){
        $passeio_valido = false;
        $_SESSION['mensagem'] = "Comentário inválido";
    } else if($preco==0){
        $passeio_valido = false;
        $_SESSION['mensagem'] = "Preço inválido";
    }

    
    //Se descrição tem algo escrito e o preço tem valor diferente de zero, insere no banco
    if($passeio_valido){
        $sql = "insert into Passeio(id_viagem, descricao, preco) values(".$id_viagem.", '".$descricao."', ".$preco.");";
        mysqli_query($conn,$sql);
        header("Location: consultar_viagens.php");
    } else {
        $_SESSION['mensagem'] = ''
        header("Location: adicionar_passeio.php?id=$id_viagem");
    }

    
    
?>
