<?php
	session_start();

    // Informações do banco de dados
	$servername = "localhost";
	$username = "root";
	$password = "123456";
	$dbname = "JoestarCompany";

	// Cria conexão com o banco
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Checa conexão
	if (mysqli_connect_error()) {
		die("Connection failed: " . mysqli_connect_error());
    } 
    
    // Entrada
    $hospedagem=$_POST['hospedagem'];
    if(isset($_POST['passeios']))
        if(!empty($_POST['passeios'])) {
            $i = 0;
            foreach($_POST['passeios'] as $selected){
                $passeios[$i]=$selected;
                $i++;
            }
        }
    $pagamento=$_POST['pagamento'];
    $id_usuario=$_SESSION['usuario_id'];
    $id_viagem=$_POST['viagem_id'];
    
    // Calcular preço
    $preco=$_POST['viagem_preco'];
    if(isset($_POST['passeios'])) {
        if(!empty($_POST['passeios'])) {
            $sql="select * from Passeio where id_viagem=". $id_viagem .";";
            $passeio_select = mysqli_query($conn,$sql);
            if(mysqli_num_rows($passeio_select) > 0) {
                while($passeio = mysqli_fetch_assoc($passeio_select)){
                    foreach($_POST['passeios'] as $selected) {
                        if($selected == $passeio['id'])
                            $preco = $preco + $passeio['preco'];
                    }
                }
            }
        }
    }

	// Insere compra no banco
    $sql="insert into Compra (id_viagem, id_usuario, id_hospedagem, preco, forma_pagamento) 
    values ('".$id_viagem."', '".$id_usuario."', '".$hospedagem."', '".$preco."', '".$pagamento."');";
        mysqli_query($conn,$sql);

    // Depois associa os passeios à compra no banco de dados
    $id_compra = mysqli_insert_id($conn);
    foreach($passeios as $selected) {
        $sql="insert into Compra_passeio (id_compra, id_passeio) 
        values ('".$id_compra."', '".$selected."')";
        mysqli_query($conn,$sql);
    }

?>
<html>
<head>
    <script>
            function mensagem(){
                alert("Compra efetuada com sucesso");
                window.location = "consultar_viagens.php";
            }
    </script>
</head>
    <body onload='mensagem()'></body>
</html>
