<?php 

    // Processar confirmação de alteração
    if (isset($_POST['confimarAlteracoes'])) {
        $idAlterar = $_POST['id'];
        $novaPergunta = $_POST['novaPergunta'];
        $novoA = $_POST['novoA'];
        $novoB = $_POST['novoB'];
        $novoC = $_POST['novoC'];
        $novoD = $_POST['novoD'];
        $novoCerto = $_POST['novaOpcaoCerta'];
        
        // Abrir o arquivo original para leitura
        $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");

        // Array para armazenar disciplinas alteradas
        $perguntasAlteradas = [];

        // Ler o arquivo e atualizar a disciplina com a sigla correspondente
        while (!feof($arqDisc)) {
            $line = fgets($arqDisc);
            $coluna = explode(";", $line);

            // Verifica se a linha foi dividida corretamente
            if (count($coluna) >= 6) {
                $id = $coluna[0];
                $pergunta = $coluna[1];
                $A = $coluna[2];
                $B = $coluna[3];
                $C = $coluna[4];
                $D = $coluna[5];
                $perguntaCrto = $coluna[6];

                // Verifica se é a disciplina a ser alterada
                if (($id) === ($idAlterar)) {
                    // Atualiza os dados, incluindo a sigla
                    $perguntasAlteradas[] = $id . ";" . $novaPergunta . ";" . $novoA . ";" . $novoB . ";" . $novoC . ";" . $novoD . ";" .  $novoCerto;
                } else {
                    // Mantém a disciplina original
                    $perguntasAlteradas[] = $line;
                }
            }
        }

        fclose($arqDisc);

        // Abrir o arquivo novamente para escrita, sobrescrevendo com disciplinas alteradas
        $arqDisc = fopen("perguntas.txt", "w") or die("Erro ao abrir o arquivo para escrita");

        foreach ($perguntasAlteradas as $pergunta) {
            fwrite($arqDisc, $pergunta);
        }

        fclose($arqDisc);

        // Redireciona para uma página de confirmação ou volta para a página anterior
        header("Location: listaPerguntas.php"); // Substitua "sucesso.php" pelo nome da página desejada
        exit(); // Encerra o script após o redirecionamento
    }

?>