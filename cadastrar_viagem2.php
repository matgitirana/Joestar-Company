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
                echo 'ui';
            }
            $lista_hospedagem_tamanho++;
        }
    }
    $preco_translado=$_POST['preco_translado'];
    $transporte=$_POST['transporte'];
    $translado=$_POST['translado'];
    //$passeios=$_POST['passeios'];

    //Validação do cadastro
    $today = date("Y-m-d");
    
    if(strlen($destino)==0){
        $cadastro_valido=false;
        echo '1;';
    } else if(filesize($_FILES['foto']==0)){
        $cadastro_valido=false;
        echo '2;';
    } else if($translado==true && ($preco_translado==0 || !isset($preco_translado))){
        $cadastro_valido=false;
        echo '3;';
    } else if(strlen($data_partida)!=10){
        $cadastro_valido=false;
        echo '4;';
    } else if(date_create($data_partida)<=date_create($today)){
        $cadastro_valido=false;
        echo '5;';
    }
        
    
    
    if($cadastro_valido==true){
        //Verifica qual será o id da nova viagem para usar no caminho da foto
        $sql="select count(id) as quantidade from Viagem;";
        $sql_resultado = mysqli_query($conn,$sql);
        $consulta = mysqli_fetch_assoc($sql_resultado);
        $id_viagem = $consulta['quantidade']+1;

        //Upload da foto da viagem
        $extensao = strtolower(substr($_FILES['foto']['name'],-4));
        $diretorio = 'fotos/viagens/';
        $caminho_foto = $diretorio . 'viagem_id_' . $id_viagem. $extensao;
        move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto);
        
        //disponibilidade 1 = ativo
        $disponibilidade = '1';

        if($translado==false){
            $preco_translado=0;
        }
		
		//Insere viagem no banco
        $sql="insert into Viagem(destino, data_partida, transporte, translado,  disponibilidade,  preco_translado, caminho_foto) values ('".$destino."', '".$data_partida."', '".$transporte."', '".$translado."', '".$disponibilidade."', ".$preco_translado.", '".$caminho_foto."');";
        mysqli_query($conn,$sql);
        for($i=0;$i<$lista_hospedagem_tamanho;$i++){
            $sql = "insert into Hospedagem(id_viagem, estrelas, preco_diaria) values (".$id_viagem.", ".$hospedagem[$i].", ".$preco_diaria[$i].");";
            mysqli_query($conn,$sql);
        }
        
        
        //header("Location: home.php");
    } else{
        //header("Location: cadastrar_viagem.php");
    }
?>
