<?php
   if(isset($_FILES['arquivo']))
   {
      
      $ext = strtolower(substr($_FILES['arquivo']['name'],-4)); //Pegando //extensão do arquivo

	  $dir = 'uploads/'; //Diretório para uploads

      move_uploaded_file($_FILES['arquivo']['tmp_name'], $dir . $_POST['nome_user'] . '001' . $ext); //Fazer upload do //arquivo
   }
   
   echo "<img src=" . $dir . $_POST['nome_user'] . '001' . $ext .">";
?>
