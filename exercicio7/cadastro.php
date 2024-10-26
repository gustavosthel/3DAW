<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição e converte o JSON em um array PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Captura os dados do JSON
    $nome = $data["nome"] ?? null;
    $email = $data["email"] ?? null;
    $senha = $data["senha"] ?? null;

    // Verifica se os campos não estão vazios
    if (!empty($nome) && !empty($email) && !empty($senha)) {
        $arqDisc = fopen("usuario.txt", "a") or die("Erro ao criar arquivo");
        $linha = $nome . ";" . $email . ";" . $senha . "\n";
        fwrite($arqDisc, $linha);
        fclose($arqDisc);

        // Responde com um código de sucesso
        http_response_code(200);
        echo "Usuário salvo com sucesso!";
    } else {
        http_response_code(400);
        echo "Preencha todos os campos.";
    }
}
?>
