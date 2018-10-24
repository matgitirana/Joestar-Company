<?php
	session_start();
	if(!isset($_SESSION['usuario_sessao'])){
		$_SESSION["usuario_sessao"] = "";
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


        //user input
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
        
        //check inputs

        $cadastro_valido = true;	
        //check if CPF is already registered
        $sql="select count(cpf) as quantidade from Pessoa where cpf = '".$cpf."';";
		$sqlResultado = $conn->query($sql);
		$consulta = mysqli_fetch_assoc($sqlResultado);
        $qtdCpf = $consulta['quantidade'];

        //check if RG is already registered
        $sql="select count(cpf) as quantidade from Pessoa where cpf = '".$rg."';";
		$sqlResultado = $conn->query($sql);
		$consulta = mysqli_fetch_assoc($sqlResultado);
		$qtdCpf = $consulta['quantidade'];
		
		//check if login is already registered
		$sql="select count(login) as quantidade from Pessoa where login = '".$login."';";
		$sqlResultado = $conn->query($sql);
		$consulta = mysqli_fetch_assoc($sqlResultado);
		$qtdLogin = $consulta['quantidade'];
		$today = date("Y-m-d");
        
        if(validar_cpf($cpf)==false){
			$cadastroValido=false;
		} else if($qtdCpf!=0){
			$cadastroValido=false;
		} else if(strlen($nome)==0){
			$cadastroValido=false;
		} else if(strlen($sobrenome)==0){
            $cadastro_valido=false;
		} else if(strlen($endereco)==0){
			$cadastroValido=false;
		} else if(strlen($login)==0){
			$cadastroValido=false;
		} else if($qtdLogin!=0){
			$cadastroValido=false;
		} else if(strlen($rg)==0){
			$cadastroValido=false;
		} else if($rg!=0){
			$cadastroValido=false;
		} else if(strlen($senha)<8){
			$cadastroValido=false;
		} else if(strlen($telefone)<8){
			$cadastroValido=false;
		} else if(strlen($data_nascimento)!=10){
			$cadastroValido=false;
		} else if(date_create($data_nascimento)>=date_create($today)){
			$cadastroValido=false;
		}
		
        if($cadastro_valido){
            $caminho_foto="";
            if(filesize($_FILES['foto']!=0)){
                $extensao = strtolower(substr($_FILES['foto']['name'],-4)); //Pegando extensão do arquivo

                $diretorio = 'fotos/'; //Diretório para uploads
                $caminho_foto = $diretorio . 'foto_' . $_POST['usuario']. $extensao;
                move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto); //Fazer upload do arquivo
            }
            $sql="insert into Pessoa (cpf, rg, nome, sobrenome, sexo, endereco, telefone, dataNascimento, tipo, status, login,  senha, caminhoFoto) values ('".$cpf."', '".$rg."', '".$nome."', '".$sobrenome."', '".$sexo."', '".$endereco."', '".$telefone."', '".$data_nascimento."', '".$tipo."', '".$status."', '".$usuario."', '".$senha."', '".$caminho_foto."');"
            $sqlResultado = $conn->query($sql);
            
            header("Location: login.php");
        } else{
            header("Location: cadastro.php");
        }
?>
