<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lê o corpo da requisição e converte o JSON em um array PHP
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        /// Captura os dados do formulário
        $id = uniqid(); 
        $questao = $data["questao"] ?? null;
        $opcaoA = $data["opcaoA"] ?? null;
        $opcaoB = $data["opcaoB"] ?? null;
        $opcaoC = $data["opcaoC"] ?? null;
        $opcaoD = $data["opcaoD"] ?? null;
        $opcaoCerta = $data["opcaoCerta"] ?? null;

        // Verifica se os campos não estão vazios
        if (!empty($questao) && !empty($opcaoA) && !empty($opcaoB) && !empty($opcaoC) && !empty($opcaoD) && !empty($opcaoCerta)) {

            // Tenta abrir o arquivo para escrita
            $arqDisc2 = fopen("perguntas.txt", "a") or die("Erro ao criar arquivo");            
            $linha2 = $id . ";" . $questao . ";" . $opcaoA . ";" . $opcaoB . ";" . $opcaoC . ";" . $opcaoD . ";" . $opcaoCerta . "\n";
            fwrite($arqDisc2, $linha2); 
            fclose($arqDisc2);

            // Responde com um código de sucesso
            http_response_code(200);
        } else {
            // Responde com um erro caso os campos estejam vazios
            http_response_code(400);
        }
    }
?>