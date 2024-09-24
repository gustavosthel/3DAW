<?php 

    // Processar confirmação de exclusão
    if (isset($_POST['confirmarExclusao'])) {
        $idExcluir = $_POST['idExcluirConfirmada'];
    
        // Abrir o arquivo original para leitura
        $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");
    
        // Array para armazenar disciplinas que não serão excluídas
        $perguntasRestantes = [];
    
        // Ler o arquivo e armazenar disciplinas, exceto a que tem a sigla a ser excluída
        while (!feof($arqDisc)) {
            $line = fgets($arqDisc);
            $coluna = explode(";", $line);
    
            // Verifica se a linha foi dividida corretamente em pelo menos 3 colunas
            if (count($coluna) >= 6) {
                $id = $coluna[0];
                $pergunta = $coluna[1];
                $A = $coluna[2];
                $B = $coluna[3];
                $C = $coluna[4];
                $D = $coluna[5];
                $perguntaCrto = $coluna[6];
    
                // Verifica se a sigla não é a que queremos excluir
                if ($id !== $idExcluir) {
                    // Se não for, armazenar a disciplina no array
                    $perguntasRestantes[] = $line;
                }
            }
        }
    
        fclose($arqDisc);
    
        // Abrir o arquivo novamente para escrita, sobrescrevendo com disciplinas restantes
        $arqDisc = fopen("perguntas.txt", "w") or die("Erro ao abrir o arquivo para escrita");
    
        foreach ($perguntasRestantes as $pergunta) {
            fwrite($arqDisc, $pergunta);
        }
    
        fclose($arqDisc);
    
        // Redireciona para uma página de confirmação ou volta para a página anterior
        header("Location: listaPerguntas.php"); // Substitua "sucesso.php" pelo nome da página desejada
        exit(); // Encerra o script após o redirecionamento
    }

?>