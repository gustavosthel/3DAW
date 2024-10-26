<?php
$arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");

$perguntas = [];

while (!feof($arqDisc)) {
    $line = fgets($arqDisc);

    if (!empty($line)) {
        $coluna = explode(";", $line);

        if (count($coluna) >= 7) {
            $perguntas[] = [
                'id' => $coluna[0],
                'questao' => $coluna[1],
                'A' => $coluna[2],
                'B' => $coluna[3],
                'C' => $coluna[4],
                'D' => $coluna[5],
                'resposta' => $coluna[6]
            ];
        }
    }
}

fclose($arqDisc);

// Retorna os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($perguntas);
?>
