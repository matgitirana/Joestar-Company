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

    $cadastro_valido=true;
    $lista_hospedagem_tamanho = 0;
    //Entrada do usuário
    $destino=$_POST['destino'];
    $data_partida=$_POST['data_partida'];
    for($i=1;$i<6;$i++){
        if(isset($_POST['hospedagem'.$i])){
            $hospedagem[$lista_hospedagem_tamanho]=$_POST['hospedagem'.$i];
            $preco_diaria[$lista_hospedagem_tamanho]=$_POST['preco_diaria'.$i];
            if($preco_diaria[$lista_hospedagem_tamanho]==0 || strlen($preco_diaria[$lista_hospedagem_tamanho])<1){
                $cadastro_valido = false;
                $_SESSION['mensagem'] = 'Preço de hospedagem inválido';
            }
            $lista_hospedagem_tamanho++;
        }
    }
    if(isset($_POST['preco_translado']))
        $preco_translado=$_POST['preco_translado'];
    else
        $preco_translado = 0;

    $transporte=$_POST['transporte'];
    $translado=$_POST['translado'];

    //Validação do cadastro
    $today = date("Y-m-d");
    
    if(strlen($destino)==0){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = 'Destino inválido';
    } else if(!is_uploaded_file($_FILES['foto']['tmp_name'])){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = 'Foto é obrigatória';
    } else if($translado=='1' && $preco_translado==0){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = 'Preço de translado inválido';
    } else if(strlen($data_partida)!=10 || date_create($data_partida)<=date_create($today)){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = 'Data de partida inválida';
    }
        
    if($cadastro_valido==true){
        
        //disponibilidade 1 = ativo
        $disponibilidade = '1';

        if($translado==false){
            $preco_translado=0;
        }
		
		//Insere viagem no banco
        $sql="insert into Viagem(destino, data_partida, transporte, translado,  disponibilidade,  preco_translado) values ('".$destino."', '".$data_partida."', '".$transporte."', '".$translado."', '".$disponibilidade."', ".$preco_translado.");";
        mysqli_query($conn,$sql);
        for($i=0;$i<$lista_hospedagem_tamanho;$i++){
            $sql = "insert into Hospedagem(id_viagem, estrelas, preco_diaria) values (".$id_viagem.", ".$hospedagem[$i].", ".$preco_diaria[$i].");";
            mysqli_query($conn,$sql);
        }
        
        //Verifica qual foi o id da nova viagem para usar no caminho da foto
        $id_viagem = mysqli_insert_id($conn);

        //Upload da foto da viagem
        $array = explode(".", $_FILES['foto']['name'], 2);
        $extensao = ".".$array[1];
        $diretorio = 'fotos/usuarios/';
        $caminho_foto = $diretorio . 'foto_usuario_' . $id_usuario. $extensao;
        move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto);

        //insere o caminho da foto no banco
        $sql="update Viagem set caminho_foto = '".$caminho_foto."' where id = ".$id_viagem.";";
        mysqli_query($conn,$sql);
        
        header("Location: consultar_viagens.php");
    } else{
        header("Location: cadastrar_viagem.php");
    }
?>
