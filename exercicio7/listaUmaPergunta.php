<?php
// Verifica se um ID foi passado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição e converte o JSON em um array PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $idBuscado = $data['idPergunta'] ?? null;

    // Abre o arquivo para leitura
    $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");

    $perguntaEncontrada = null; // Variável para armazenar a pergunta encontrada

    while (!feof($arqDisc)) {
        $line = fgets($arqDisc);

        if (!empty($line)) {
            $coluna = explode(";", $line);

            if (count($coluna) >= 7) {
                $id = trim($coluna[0]); // Pega o ID da pergunta

                // Verifica se o ID atual corresponde ao ID buscado
                if ($id === $idBuscado) {
                    $perguntaEncontrada = [
                        'id' => $coluna[0],
                        'questao' => $coluna[1],
                        'A' => $coluna[2],
                        'B' => $coluna[3],
                        'C' => $coluna[4],
                        'D' => $coluna[5],
                        'resposta' => $coluna[6]
                    ];
                    break; // Sai do loop após encontrar a pergunta
                }
            }
        }
    }

    fclose($arqDisc);

    // Define o tipo de conteúdo da resposta como JSON
    header('Content-Type: application/json');

    // Verifica se a pergunta foi encontrada e retorna os dados
    if ($perguntaEncontrada) {
        echo json_encode($perguntaEncontrada);
    } else {
        // Retorna um erro se a pergunta não for encontrada
        http_response_code(404);
        echo json_encode(['error' => 'Pergunta não encontrada']);
    }
} else {
    // Retorna um erro se o ID não for fornecido
    http_response_code(400);
    echo json_encode(['error' => 'ID não fornecido']);
}
?>
