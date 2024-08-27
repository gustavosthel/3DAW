<?php
    $a = $_GET['a'];
    $b = $_GET['b'];
    $tipo = $_GET['tipo'];
    $inverter = $_GET['inverter'];
    $result = 0;
    $result2 = 0;

    if ($tipo == 'soma') {
        $result = $a + $b;
    } elseif ($tipo == 'subtração') {
        $result = $a - $b;
    } elseif ($tipo == 'divisão') {
        $result = $a / $b;
    } elseif ($tipo == 'multiplicação') {
        $result = $a * $b;
    } elseif ($tipo == 'raiz quadrada') {
        $result = sqrt($a);
    } elseif ($tipo == 'cos') {
        $result = cos($a);
    } elseif ($tipo == 'sen') {
        $result = sin($a);
    } elseif ($tipo == 'tan') {
        $result = tan($a);
    }

    if ($inverter == 'sim') {
        $result2 = $result * -1;
    } else {
        $result2 = $result;
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
        echo "<h1>Resultado: $result2</h1>";
    ?>
    
</body>
</html>