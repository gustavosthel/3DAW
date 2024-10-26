<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição e converte o JSON em um array PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $idExcluir = $data['idExcluirConfirmada'] ?? null;

    if ($idExcluir === null) {
        // Responde com erro se o ID não foi fornecido
        http_response_code(400);
        echo json_encode(['error' => 'ID de exclusão não fornecido.']);
        exit();
    }

    // Abrir o arquivo original para leitura
    $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");

    // Array para armazenar perguntas que não serão excluídas
    $perguntasRestantes = [];

    // Ler o arquivo e armazenar perguntas, exceto a que tem o ID a ser excluído
    while (!feof($arqDisc)) {
        $line = fgets($arqDisc);
        if ($line === false) continue; // Ignora linhas vazias ou erro

        $coluna = explode(";", $line);

        // Verifica se a linha foi dividida corretamente em pelo menos 6 colunas
        if (count($coluna) >= 6) {
            $id = trim($coluna[0]); // Trim para remover espaços em branco

            // Verifica se o ID não é o que queremos excluir
            if ($id !== $idExcluir) {
                // Se não for, armazenar a pergunta no array
                $perguntasRestantes[] = $line;
            }
        }
    }

    fclose($arqDisc);

    // Abrir o arquivo novamente para escrita, sobrescrevendo com perguntas restantes
    $arqDisc = fopen("perguntas.txt", "w") or die("Erro ao abrir o arquivo para escrita");

    foreach ($perguntasRestantes as $pergunta) {
        fwrite($arqDisc, $pergunta);
    }

    fclose($arqDisc);

    // Responde com um código de sucesso e uma mensagem
    http_response_code(200);
} else {
    // Responde com um erro caso a requisição não seja POST
    http_response_code(400);
}

?>
