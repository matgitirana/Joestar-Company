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
        $linhas = explode ("\r\n", $conteudo);

        for ($i = 0; $i < sizeof($linhas); $i++) {
            
            $lista_usuarios [$i] = explode ("|", $linhas [$i]);
        }

        for ($i = 0; $i < sizeof($linhas); $i++) {
            list($nome_s[$i], $sobrenome_s[$i], $data_s[$i], $endereco_s[$i], $telefone_s[$i], $sexo_s[$i], $rg_s[$i], $cpf_s[$i], $foto_s[$i], $usuario_s[$i], $senha_s[$i]) = explode ("|", $linhas [$i]);
        }
        
        for($i=0; $i< sizeof($lista_usuarios); $i++){
                if($usuario_s[$i] == $usuario && $senha_s[$i] == $senha){
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