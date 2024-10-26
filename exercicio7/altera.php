<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição e converte o JSON em um array PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Captura os dados do formulário
    $idAlterar = $data['id'] ?? null;
    $novaPergunta = $data["novaPergunta"] ?? null;
    $novaOpcaoA = $data["novaOpcaoA"] ?? null;
    $novaOpcaoB = $data["novaOpcaoB"] ?? null;
    $novaOpcaoC = $data["novaOpcaoC"] ?? null;
    $novaOpcaoD = $data["novaOpcaoD"] ?? null;
    $opcaoCerta = $data["novaOpcaoCerta"] ?? null;

    // Abrir o arquivo original para leitura
    $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");

    // Array para armazenar perguntas alteradas
    $perguntasAlteradas = [];

    // Ler o arquivo e atualizar a pergunta com o id correspondente
    while (!feof($arqDisc)) {
        $line = fgets($arqDisc);
        $coluna = explode(";", $line);

        // Verifica se a linha foi dividida corretamente
        if (count($coluna) >= 7) { // Certifique-se de que o número de colunas é correto
            $id = $coluna[0];
            $pergunta = $coluna[1];
            $A = $coluna[2];
            $B = $coluna[3];
            $C = $coluna[4];
            $D = $coluna[5];
            $perguntaCerta = $coluna[6];

            // Verifica se é a pergunta a ser alterada
            if ($id === $idAlterar) {
                // Atualiza os dados
                $perguntasAlteradas[] = $id . ";" . $novaPergunta . ";" . $novaOpcaoA . ";" . $novaOpcaoB . ";" . $novaOpcaoC . ";" . $novaOpcaoD . ";" . $opcaoCerta . "\n";
            } else {
                // Mantém a pergunta original
                $perguntasAlteradas[] = $line;
            }
        }
    }

    fclose($arqDisc);

    // Abrir o arquivo novamente para escrita, sobrescrevendo com perguntas alteradas
    $arqDisc = fopen("perguntas.txt", "w") or die("Erro ao abrir o arquivo para escrita");

    foreach ($perguntasAlteradas as $pergunta) {
        fwrite($arqDisc, $pergunta);
    }

    fclose($arqDisc);

    // Responde com um código de sucesso
    http_response_code(200);
} else {
    // Responde com um erro caso a requisição não seja POST
    http_response_code(400);
}
?>
