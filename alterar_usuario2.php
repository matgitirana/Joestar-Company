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
	$senha=strrev($_POST['senha']);
    $telefone=$_POST['telefone'];

    // Usado para checar se já existe um usuário com o cpf informado
    $sql="select count(cpf) as quantidade from Usuario where cpf = '".$cpf."' and disponibilidade='1';";
    $sql_resultado = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sql_resultado);
    $qtdCpf = $consulta['quantidade'];

    // Usado para checar se já existe um usuário com o rg informado
    $sql="select count(rg) as quantidade from Usuario where rg = '".$rg."' and disponibilidade='1';";
    $sql_resultado = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sql_resultado);
    $qtdRg = $consulta['quantidade'];
    
    // Usado para checar se já existe um usuário com o login informado
    $sql="select count(login) as quantidade from Usuario where login = '".$usuario."' and disponibilidade='1';";
    $sql_resultado = mysqli_query($conn,$sql);
    $consulta = mysqli_fetch_assoc($sql_resultado);
    $qtdLogin = $consulta['quantidade'];

    // Informações atuais do usuário
    $sql="select id, rg, cpf, login, caminho_foto from Usuario where id = '".$_SESSION["usuario_id"]."';";
    $sql_resultado = mysqli_query($conn,$sql);
    $informacao_atual = mysqli_fetch_assoc($sql_resultado);
        
    //Validação das informações
    $cadastro_valido = true;
    $today = date("Y-m-d");


    if(validar_cpf($cpf)==false){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "CPF inválido";
    } else if($qtdCpf!=0 && $cpf!=$informacao_atual['cpf']){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "CPF repetido";
    } else if(strlen($nome)==0){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "Nome inválido";
    } else if(strlen($sobrenome)==0){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "Sobrenome inválido";
    } else if(strlen($endereco)==0){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "Endereço inválido";
    } else if(strlen($usuario)==0){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "Login inválido";
    } else if($qtdLogin!=0  && $usuario!=$informacao_atual['login']){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "Login repetido";
    } else if(strlen($rg)==0){
    	$cadastro_valido=false;
    } else if($qtdRg!=0 && $rg!=$informacao_atual['rg']){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "RG repetido";
    } else if(strlen($senha)<5){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "Senha inválida";
    } else if(strlen($telefone)<8){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "Telefone inválido";
    } else if(strlen($data_nascimento)!=10 || date_create($data_nascimento)>=date_create($today)){
        $cadastro_valido=false;
        $_SESSION['mensagem'] = "Data de nascimento inválida";
    }

    if($cadastro_valido==true){
        // Se não tiver foto nova, fica a anterior; Se tiver foto nova, faz o upload dela
        $caminho_foto = $informacao_atual['caminho_foto'];
        if(is_uploaded_file($_FILES['foto']['tmp_name'])){
            $array = explode(".", $_FILES['foto']['name'], 2);
            $extensao = ".".$array[1];
            $diretorio = 'fotos/usuarios/';
            $caminho_foto = $diretorio . 'foto_usuario_' . $id_usuario. $extensao;
            move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto);
        }
		
		// Atualiza o usuário com todas as informações
        $sql="update Usuario set cpf = '".$cpf."', rg = '".$rg."', nome = '".$nome."', sobrenome = '".$sobrenome."', sexo = '".$sexo."', endereco = '".$endereco."', telefone = '".$telefone."', data_nascimento = '".$data_nascimento."', login = '".$usuario."',  senha = '".$senha."', caminho_foto = '".$caminho_foto."' where id= ".$informacao_atual['id'].";";
        mysqli_query($conn,$sql);
            
        header("Location: ver_perfil.php");
    } else{
        header("Location: alterar_usuario.php");
    }
?>
