<?php
    session_start();
    if(!isset($_SESSION['usuario_id']))
        $_SESSION['usuario_id'] = '';
    if(!isset($_SESSION['tipo_usuario']))
        $_SESSION["tipo_usuario"] = "";
    if(!isset($_SESSION['mensagem']))
		$_SESSION['mensagem'] = '';

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

    //ID da viagem
	$id = $_GET['id'];
	
    //Informações da viagem
    $sql="select id from Viagem where id = ".$id." and disponibilidade=1;";
    $sql_resultado = mysqli_query($conn,$sql);    
?>

<html>
    <head>
        <title> Agência de Viagens - Cadastro </title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="estilo.css" type="text/css" />
        <script>
            function mostrar_erro(){
                var mensagem_erro = "<?php echo $_SESSION['mensagem'] ?>";
                if(mensagem_erro!=''){
                    alert(mensagem_erro);
                    <?php $_SESSION['mensagem'] = ''; ?>
                }
            }
        </script>
    </head>

    <body onload='mostrar_erro()'>

        <div id="topo">
            <ul id="menu">
				<?php
                    //Menu diferente de acordo com o tipo de usuário
                    if($_SESSION['tipo_usuario'] == ""){
                        echo "
                        <li><a href='home.php'>Home</a></li>
                        <li><a href='consultar_viagens.php'>Viagens</a></li>
                        <li><a href='login.php'>Login</a></li>
                        ";
                    } else if($_SESSION['tipo_usuario'] == 'cliente'){
                        echo "
                        <li><a href='home.php'>Home</a></li>
                        <li><a href='consultar_viagens.php'>Viagens</a></li>
                        <li><a href='ver_perfil.php'>Perfil</a></li>
                        <li><a href='consulta_compras.php'>Compras</a></li>
                        <li><a href='logout.php'>Logout</a></li>
                        ";
                    } else if($_SESSION['tipo_usuario'] == 'adm'){
                        echo "
                        <li><a href='home.php'>Home</a></li>
                        <li><a href='consultar_viagens.php'>Viagens</a></li>
                        <li><a href='ver_perfil.php'>Perfil</a></li>
                        <li><a href='consulta_compras.php'>Compras</a></li>
                        <li><a href='ver_usuarios.php'>Usuários</a></li>
                        <li><a href='cadastrar_viagem.php'>Nova viagem</a></li>
                        <li><a href='cadastrar_usuario.php'>Novo adm</a></li>
                        <li><a href='logout.php'>Logout</a></li>
                        ";
                    }
                ?>					
			</ul>
        </div>

        <?php
        if($_SESSION['tipo_usuario']=='adm'){
            if(mysqli_num_rows($sql_resultado)>0){
                //Mostra todas as informações da viagem e não deixa usuário editar
                echo "
                <form action='adicionar_passeio2.php' method='post' enctype='multipart/form-data'>
                <table align='center' border='0' width =35%>
    
                    <tr>
                        <td colspan='2' align='center'><h2>Cadastrar passeio</h2></td>
                    </tr>
    
                    <input type='hidden' name='id_viagem' value='".$id."'>
    
                    <tr>
                        <td><label>Descrição</label></td>
                        <td>
                            <textarea textarea name='descricao' rows='4' cols='30' maxlength='500' placeholder='Descreva sobre o passeio aqui'></textarea>>
                        </td>
                    </tr>	
                    
                    <tr>
                        <td><label>Preço do passeio</label></td>
                        <td>
                            <input type='number' size='30' name='preco_passeio' step='0.01'>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align='center' colspan='2'>
                            <input type='submit' value='Criar'>
                        </td>
                        
                    </tr>
                    
                    
                </table>
                </form>
                ";
            } else{
                echo "Essa viagem não existe.";
            }
        } else{
            echo "Vocẽ não tem acesso a essa página";
        }

        
        ?>

		<div id='rodape'>
			<footer>
				Agênica de Viagens - 2018
			</footer>
		</div>

    </body>
</html>
