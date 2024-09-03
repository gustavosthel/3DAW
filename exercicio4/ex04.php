<?php

    // $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao criar arquivo");

    // if (!$arqDisc) {
    //     exit("Falha ao abrir o arquivo");
    // }

    // esse tambem funciona, pode ser ate melhor 
    // while (($line = fgets($arqDisc)) !== false) {
    //     echo $line . "<br>";
    // }

    // while(!feof($arqDisc)) {
        
    //     $line = fgets($arqDisc);
    //     $coluna = explode(";", $line);
    //     //echo "Nome: " . $coluna[0] . " Sigla: " . $coluna[1] . " Carga: " . $coluna[2] . "<br>";
    //     echo "<tr><td>" . $coluna[0] . "</td>" 
    //     . "<td>" . $coluna[1] . "</td>" 
    //     . "<td>" . $coluna[2] . "</td></tr>";
    // }

    // fclose($arqDisc);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<table>
    <tr>
        <th>Nome</th>
        <th>Sigla</th>
        <th>Carga Horaria</th>
    </tr>
    <?php

    $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao criar arquivo");

    if (!$arqDisc) {
        exit("Falha ao abrir o arquivo");
    }

    
    while(!feof($arqDisc)) {
        
        $line = fgets($arqDisc);
        $coluna = explode(";", $line);
        //echo "Nome: " . $coluna[0] . " Sigla: " . $coluna[1] . " Carga: " . $coluna[2] . "<br>";
        echo "<tr><td>" . $coluna[0] . "</td>" 
        . "<td>" . $coluna[1] . "</td>" 
        . "<td>" . $coluna[2] . "</td></tr>";
    }

    fclose($arqDisc);
    
    ?>
</table>
    
</body>
</html>