<?php
	session_start();
	if(!isset($_SESSION['usuario_sessao'])){
		$_SESSION["usuario_sessao"] = "";
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
    
        
        $rg=$_POST['rg'];
		$cpf=$_POST['cpf'];
        $nome=$_POST['nome'];
        $sobrenome=$_POST['sobrenome'];
        $data_nascimento=$_POST['data_nascimento'];
        $data_nascimento_date = date_create($data_nascimento);
        $hoje_date = date_create(date('Y-m-d'));
        
		$sexo=$_POST['sexo'];
		$endereco=$_POST['endereco'];
		$usuario=$_POST['usuario'];
		$senha=$_POST['senha'];
        $telefone=$_POST['telefone'];
        

        $cadastro_valido = true;		
        

        $arquivo_usuario = "arquivos/usuarios.txt";
		
		if(validar_cpf($cpf)==false){
            $cadastro_valido=false;
		} else if(strlen($nome)==0){
            $cadastro_valido=false;
		} else if(strlen($sobrenome)==0){
            $cadastro_valido=false;
		} else if(strlen($endereco)==0){
            $cadastro_valido=false;
		} else if(strlen($usuario)==0){
            $cadastro_valido=false;
		} else if(strlen($senha)<8){
            $cadastro_valido=false;
		} else if(strlen($telefone)<8){
            $cadastro_valido=false;
		} else if($data_nascimento_date>$hoje_date){
            $cadastro_valido=false;
        } else if(!isset($_FILES['foto'])){
            $cadastro_valido=false;
        } else if(filesize($arquivo_usuario) !=0){
            
            $conteudo = file_get_contents($arquivo_usuario);
            // Separa as linhas
            $linhas = explode ("\r\n", $conteudo);

            // Separa os registros
            for ($i = 0; $i < sizeof($linhas); $i++) {
                list($nome_s[$i], $sobrenome_s[$i], $data_s[$i], $endereco_s[$i], $telefone_s[$i], $sexo_s[$i], $rg_s[$i], $cpf_s[$i], $foto_s[$i], $usuario_s[$i], $senha_s[$i]) = explode ("|", $linhas [$i]);
            }

            for($i=0; $i< sizeof($linhas); $i++){
                if($usuario_s[$i] == $usuario || $cpf[$i] == $pf){
                    $cadastro_valido=false;
                }
                
            }
        }
		
        if($cadastro_valido){

            $extensao = strtolower(substr($_FILES['foto']['name'],-4)); //Pegando //extensão do arquivo

            $diretorio = 'fotos/'; //Diretório para uploads
            $caminho_foto = $diretorio . 'foto_' . $_POST['usuario']. $extensao;
            move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto); //Fazer upload do //arquivo

            $cadastro_texto = $nome . "|" . $sobrenome . "|" . $data_nascimento . "|" . $endereco . "|" . $telefone . "|" . $sexo . "|" . $rg . "|" .$cpf . "|" . $caminho_foto ."|" . $usuario . "|" . $senha . "\r\n";

            $arquivo_usuario = "arquivos/usuarios.txt";
            $conteudo = file_get_contents($arquivo_usuario);
            $conteudo .= $cadastro_texto;
            file_put_contents($arquivo_usuario, $conteudo);
            header("Location: login.php");
        } else{
            header("Location: cadastro.php");
        }
	
?>