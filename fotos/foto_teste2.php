<?php

// Ler o arquivo
//$str = file_get_contents("E:\alunos.txt", "r");
$str = "001|Robson Godoi|Sistema de Informacao|2017-05-15|100,00" . "\r\n" . 
	   "002|Ana Maria|Psicologia|2018-01-17|150,50";

echo "<pre>";
echo $str. "<br>". "<br>";

// Separa as linhas
$linhas = explode ("\r\n", $str);
print_r($linhas);
echo sizeof($linhas) . "<br>". "<br>";

// Separa os registros
for ($i = 0; $i < sizeof($linhas); $i++) {
    $alunos [$i] = explode ("|", $linhas [$i]);
}
print_r($alunos);

echo "</pre>";

?>


<li><a href='logout.php'>Login</a></li>
<li><a href='viagem_dos_sonhos.php'>Viagem dos Sonhos</a></li>