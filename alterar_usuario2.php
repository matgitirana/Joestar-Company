<?php
	session_start();

    // Informação do banco de dados
	$servername = "localhost";
	$username = "root";
	$password = "123456";
	$dbname = "JoestarCompany";

	// Cria conexão com o banco
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Checa a conexão
	if (mysqli_connect_error()) {
		die("Connection failed: " . mysqli_connect_error());
    } 
    
    // Função para validar o cpf
    function validar_cpf($cpf){
        //Verifica se o tamanho está correto
        if (strlen($cpf) != 11) {
            return false;
        }
        //Verifica se o cpf é o mesmo número reptido 11 vezes
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        //Cálculo de verificação do dígito identificador
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

    // Entrada do usuário
    $rg=$_POST['rg'];
	$cpf=$_POST['cpf'];
    $nome=$_POST['nome'];
    $sobrenome=$_POST['sobrenome'];
    $data_nascimento=$_POST['data_nascimento'];
	$sexo=$_POST['sexo'];
	$endereco=$_POST['endereco'];
	$usuario=$_POST['usuario'];
	$senha=$_POST['senha'];
    $telefone=$_POST['telefone'];

    //Validação das informações
    $cadastro_valido = true;
    $today = date("Y-m-d");

    // Usado para checar se já existe um usuário com o cpf informado
    $sql="select count(cpf) as quantidade from Usuario where cpf = '".$cpf."' and status='1';";
    $sql_resultadoado = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sql_resultadoado);
    $qtdCpf = $consulta['quantidade'];

    // Usado para checar se já existe um usuário com o rg informado
    $sql="select count(rg) as quantidade from Usuario where rg = '".$rg."' and status='1';";
    $sql_resultadoado = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sql_resultadoado);
    $qtdRg = $consulta['quantidade'];
    
    // Usado para checar se já existe um usuário com o login informado
    $sql="select count(login) as quantidade from Usuario where login = '".$usuario."' and status='1';";
    $sql_resultadoado = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sql_resultadoado);
    $qtdLogin = $consulta['quantidade'];

    // Informações atuais do usuário
    $sql="select id, rg, cpf, login, caminho_foto from Usuario where id = '".$_SESSION["usuario_id"]."';";
    $sql_resultadoado = mysqli_query($conn,$sql);
    $informacao_atual = mysqli_fetch_assoc($sql_resultadoado);
        
    if(validar_cpf($cpf)==false){
		$cadastro_valido=false;
    } else if($qtdCpf!=0 && $cpf!=$informacao_atual['cpf']){
    	$cadastro_valido=false;
    } else if(strlen($nome)==0){
    	$cadastro_valido=false;
    } else if(strlen($sobrenome)==0){
        $cadastro_valido=false;
    } else if(strlen($endereco)==0){
    	$cadastro_valido=false;
    } else if(strlen($usuario)==0){
    	$cadastro_valido=false;
    } else if($qtdLogin!=0  && $usuario!=$informacao_atual['login']){
    	$cadastro_valido=false;
    } else if(strlen($rg)==0){
    	$cadastro_valido=false;
    } else if($qtdRg!=0 && $rg!=$informacao_atual['rg']){
    	$cadastro_valido=false;
    } else if(strlen($senha)<5){
    	$cadastro_valido=false;
    } else if(strlen($telefone)<8){
    	$cadastro_valido=false;
    } else if(strlen($data_nascimento)!=10){
    	$cadastro_valido=false;
    } else if(date_create($data_nascimento)>=date_create($today)){
    	$cadastro_valido=false;
    }
    
    if($cadastro_valido==true){
        // Se não tiver foto nova, fica a anterior; Se tiver foto nova, faz o upload dela
        $caminho_foto = $informacao_atual['caminho_foto'];
        if(filesize($_FILES['foto']!=0)){
            $extensao = strtolower(substr($_FILES['foto']['name'],-4)); //Pegando extensão do arquivo
            $diretorio = 'fotos/usuarios/'; //Diretório para uploads
            $caminho_foto = $diretorio . 'foto_usuario_' . $informacao_atual['id']. $extensao;
            move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto); //Fazer upload do arquivo
        }
		
		// Atualiza o usuário com todas as informações
        $sql="update Usuario set cpf = '".$cpf."', rg = '".$rg."', nome = '".$nome."', sobrenome = '".$sobrenome."', sexo = '".$sexo."', endereco = '".$endereco."', telefone = '".$telefone."', data_nascimento = '".$data_nascimento."', login = '".$usuario."',  senha = '".$senha."', caminho_foto = '".$caminho_foto."' where id= ".$informacao_atual['id'].";";
        mysqli_query($conn,$sql);
            
        header("Location: home.php");
    } else{
        header("Location: alterar_usuario.php");
    }
?>
