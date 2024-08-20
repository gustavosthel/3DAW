<?php
    $a = $_GET['a'];
    $b = $_GET['b'];
    $tipo = $_GET['tipo'];
    $result = 0;

    if ($tipo == 'soma') {
        $result = $a + $b;
    } elseif ($tipo == 'subtração') {
        $result = $a - $b;
    } elseif ($tipo == 'divisão') {
        $result = $a / $b;
    } elseif ($tipo == 'multiplicação') {
        $result = $a * $b;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        echo "<h1>Resultado: $result</h1>";
    ?>
    
</body>
</html>