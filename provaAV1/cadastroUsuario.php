<?php

    // Inicializa a variável de mensagem
    $msg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Captura os dados do formulário diretamente, sem verificar isset 
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        // Verifica se os campos não estão vazios
        if (!empty($nome) && !empty($email) && !empty($senha)) {

            // Tenta abrir o arquivo para escrita
            $arqDisc = fopen("usuario.txt", "a") or die("Erro ao criar arquivo");
            $linha = $nome . ";" . $email . ";" . $senha . "\n";
            fwrite($arqDisc, $linha);
            fclose($arqDisc);

            // Redireciona para uma página de confirmação ou volta para a página anterior
            header("Location: cadastroUsuario.html");
            exit(); // Encerra o script após o redirecionamento
        } else {
            $msg = "Por favor, preencha todos os campos.";
        }
    }
?>