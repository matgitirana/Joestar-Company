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
    $destino=$_POST['destino'];
    $data_partida=$_POST['data_partida'];
    $diarias=$_POST['diarias'];
    $preco_diaria=$_POST['preco_diaria'];
    $preco_translado=$_POST['preco_translado'];
    $transporte=$_POST['transporte'];
    $translado=$_POST['translado'];
    $hospedagem=$_POST['hospedagem'];
    $passeios=$_POST['passeios'];

    //Validação do cadastro
    $today = date("Y-m-d");
    $cadastro_valido=true;
    if(strlen($destino)==0){
        $cadastro_valido=false;
    } else if(strlen($diarias)<1 || $diarias==0){
        $cadastro_valido=false;
    } else if(strlen($hospedagem)==0){
        $cadastro_valido=false;
    } else if(strlen($passeios)==0){
        $cadastro_valido=false;
    } else if(filesize($_FILES['foto']==0)){
        $cadastro_valido=false;
    } else if($preco_diaria==0 || strlen($preco_diaria)<1){
        $cadastro_valido=false;
    } else if(strlen($data_partida)!=10){
        $cadastro_valido=false;
    } else if(date_create($data_partida)<=date_create($today)){
        $cadastro_valido=false;
    }
        
    
    
    if($cadastro_valido==true){
        //Verifica qual será o id da nova viagem para usar no caminho da foto
        $sql="select count(id) as quantidade from Viagem;";
        $sqlResultado = $conn->query($sql);
        $consulta = mysqli_fetch_assoc($sqlResultado);
        $id_viagem = $consulta['quantidade']+1;

        //Upload da foto da viagem
        $extensao = strtolower(substr($_FILES['foto']['name'],-4));
        $diretorio = 'fotos/viagens/';
        $caminho_foto = $diretorio . 'viagem_id_' . $id_viagem. $extensao;
        move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto);
        
        //Status da viagem: ativa
        $status = '1';

        if($preco_translado==''){
            $preco_translado=0;
        }
		
		//Insere viagem no banco
        $sql="insert into Viagem(destino, data_partida, diarias, transporte, translado, hospedagem, passeios, status, preco_diaria, preco_translado, caminho_foto) values ('".$destino."', '".$data_partida."', ".$diarias.", '".$transporte."', '".$translado."', ".$hospedagem.", '".$passeios."', '".$status."', ".$preco_diaria.", ".$preco_translado.", '".$caminho_foto."');";
        $conn->query($sql);
        
        header("Location: home.php");
    } else{
        header("Location: cadastrar_viagem.php");
    }
?>
