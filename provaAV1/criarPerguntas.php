<?php

    // Inicializa a variável de mensagem
    $msg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Captura os dados do formulário diretamente, sem verificar isset
        $id = uniqid(); 
        $questao = $_POST["questao"];
        $opcaoA = $_POST["opcaoA"];
        $opcaoB = $_POST["opcaoB"];
        $opcaoC = $_POST["opcaoC"];
        $opcaoD = $_POST["opcaoD"];
        $opcaoCerta = $_POST["opcaoCerta"];

        // Verifica se os campos não estão vazios
        if (!empty($questao) && !empty($opcaoA) && !empty($opcaoB) && !empty($opcaoC) && !empty($opcaoD) && !empty($opcaoCerta)) {

            // Tenta abrir o arquivo para escrita
            $arqDisc2 = fopen("perguntas.txt", "a") or die("Erro ao criar arquivo");            
            $linha2 = $id . ";" . $questao . ";" . $opcaoA . ";" . $opcaoB . ";" . $opcaoC . ";" . $opcaoD . ";" . $opcaoCerta . "\n";
            fwrite($arqDisc2, $linha2); 
            fclose($arqDisc2);

            // Redireciona para uma página de confirmação ou volta para a página anterior
            header("Location: criarPerguntas.html");
            exit(); // Encerra o script após o redirecionamento
        } else {
             $msg = "Por favor, preencha todos os campos.";
        }
    }
?>