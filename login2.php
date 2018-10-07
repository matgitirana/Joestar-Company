<?php
	session_start();
	if(!isset($_SESSION['usuario_sessao'])){
		$_SESSION["usuario_sessao"] = "";
	}
	
		$usuario=$_POST['usuario'];
		$senha=$_POST['senha'];
        $login_valido = false;		
    
		
        $arquivo_usuario = "arquivos/usuarios.txt";
        $conteudo = file_get_contents($arquivo_usuario);
        // Separa as linhas
        $linhas = explode ("\r\n", $conteudo);

        // Separa os registros
        for ($i = 0; $i < sizeof($linhas); $i++) {
            
            $lista_usuarios [$i] = explode ("|", $linhas [$i]);
        }

        /*
        for ($i = 0; $i < sizeof($linhas); $i++) {
            $lista_usuarios[$i][]
            list($nome_s, $sobrenome_s, $data_s, $endereco_s, $telefone_s, $sexo_s, $rg_s, $cpf_s, $foto_s, $usuario_s, $senha_s) = explode ("|", $linhas [$i]);
        }
        */
        for($i=0; $i< sizeof($lista_usuarios); $i++){
                if($lista_usuarios[$i][9] == $usuario && $lista_usuarios[$i][10] == $senha){
                    $login_valido = true;
                }
        }
        
        
		
        if($login_valido){
            header("Location: home.php");
            $_SESSION["usuario_sessao"] = $usuario;
            
        } else{
            header("Location: login.php"); /* Redirect browser */
            exit();
        }
	
?>