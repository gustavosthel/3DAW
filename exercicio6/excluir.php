<?php 

    // Processar confirmação de exclusão
    if (isset($_POST['confirmarExclusao'])) {
        $idExcluir = $_POST['idExcluirConfirmada'];
    
        // Abrir o arquivo original para leitura
        $arqDisc = fopen("alunos.txt", "r") or die("Erro ao abrir o arquivo");
    
        // Array para armazenar disciplinas que não serão excluídas
        $alunosRestantes = [];
    
        // Ler o arquivo e armazenar disciplinas, exceto a que tem a sigla a ser excluída
        while (!feof($arqDisc)) {
            $line = fgets($arqDisc);
            $coluna = explode(";", $line);
    
            // Verifica se a linha foi dividida corretamente em pelo menos 3 colunas
            if (count($coluna) >= 4) {
                $id = $coluna[0];
                $nome = $coluna[1];
                $cpf = $coluna[2];
                $matricula = $coluna[3];
                $data = $coluna[4];
    
                // Verifica se a sigla não é a que queremos excluir
                if ($id !== $idExcluir) {
                    // Se não for, armazenar a disciplina no array
                    $alunosRestantes[] = $line;
                }
            }
        }
    
        fclose($arqDisc);
    
        // Abrir o arquivo novamente para escrita, sobrescrevendo com disciplinas restantes
        $arqDisc = fopen("alunos.txt", "w") or die("Erro ao abrir o arquivo para escrita");
    
        foreach ($alunosRestantes as $aluno) {
            fwrite($arqDisc, $aluno);
        }
    
        fclose($arqDisc);
    
        // Redireciona para uma página de confirmação ou volta para a página anterior
        header("Location: ListaAlunos.php"); // Substitua "sucesso.php" pelo nome da página desejada
        exit(); // Encerra o script após o redirecionamento
    }

?>