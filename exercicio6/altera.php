<?php 

    // Processar confirmação de alteração
    if (isset($_POST['confimarAlteracoes'])) {
        $idAlterar = $_POST['id'];
        $novoNome = $_POST['novoNome'];
        $novoCpf = $_POST['novoCpf'];
        $novoMatricula = $_POST['novoMatricula'];
        $novoData = $_POST['novoData'];
        
        // Abrir o arquivo original para leitura
        $arqDisc = fopen("alunos.txt", "r") or die("Erro ao abrir o arquivo");

        if (!$arqDisc) {
            exit("Falha ao abrir o arquivo");
        }

        // Array para armazenar disciplinas alteradas
        $alunosAlteradas = [];

        // Ler o arquivo e atualizar a disciplina com a sigla correspondente
        while (!feof($arqDisc)) {
            $line = fgets($arqDisc);
            $coluna = explode(";", $line);

            // Verifica se a linha foi dividida corretamente
            if (count($coluna) >= 4) {
                $id = $coluna[0];
                $nome = $coluna[1];
                $cpf = $coluna[2];
                $matricula = $coluna[3];
                $data = $coluna[4];

                // Verifica se é a disciplina a ser alterada
                if (($id) === ($idAlterar)) {
                    // Atualiza os dados, incluindo a sigla
                    $alunosAlteradas[] = $id . ";" . $novoNome . ";" . $novoCpf . ";" . $novoMatricula . ";" . $novoData . ";";
                } else {
                    // Mantém a disciplina original
                    $alunosAlteradas[] = $line;
                }
            }
        }

        fclose($arqDisc);

        // Abrir o arquivo novamente para escrita, sobrescrevendo com disciplinas alteradas
        $arqDisc = fopen("alunos.txt", "w") or die("Erro ao abrir o arquivo para escrita");

        foreach ($alunosAlteradas as $aluno) {
            fwrite($arqDisc, $aluno);
        }

        fclose($arqDisc);

        // Redireciona para uma página de confirmação ou volta para a página anterior
        header("Location: ListaAlunos.php"); // Substitua "sucesso.php" pelo nome da página desejada
        exit(); // Encerra o script após o redirecionamento
    }

?>