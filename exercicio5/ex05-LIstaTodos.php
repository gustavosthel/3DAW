<?php

    $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");

    if (!$arqDisc) {
        exit("Falha ao abrir o arquivo");
    }

    $id = 1;

    $disciplinas = [];

    while(!feof($arqDisc)) {
        $line = fgets($arqDisc);
        $coluna = explode(";", $line);
        // Verifica se a linha foi dividida corretamente em pelo menos 3 colunas
        if (count($coluna) >= 3) {
            $disciplinas[] = [
                'id' => $id,
                'nome' => $coluna[0],
                'sigla' => $coluna[1],
                'carga' => $coluna[2]
            ];
            $id++;
        }
    }

    fclose($arqDisc);

    // Processar confirmação de exclusão
    if (isset($_POST['confirmarExclusao'])) {
    $siglaExcluir = $_POST['siglaExcluirConfirmada'];

    // Abrir o arquivo original para leitura
    $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");

    if (!$arqDisc) {
        exit("Falha ao abrir o arquivo");
    }

    // Array para armazenar disciplinas que não serão excluídas
    $disciplinasRestantes = [];

    // Ler o arquivo e armazenar disciplinas, exceto a que tem a sigla a ser excluída
    while (!feof($arqDisc)) {
        $line = fgets($arqDisc);
        $coluna = explode(";", $line);

        // Verifica se a linha foi dividida corretamente em pelo menos 3 colunas
        if (count($coluna) >= 3) {
            $nome = $coluna[0];
            $sigla = $coluna[1];
            $carga = $coluna[2];

            // Verifica se a sigla não é a que queremos excluir
            if ($sigla !== $siglaExcluir) {
                // Se não for, armazenar a disciplina no array
                $disciplinasRestantes[] = $line;
            }
        }
    }

    fclose($arqDisc);

    // Abrir o arquivo novamente para escrita, sobrescrevendo com disciplinas restantes
    $arqDisc = fopen("disciplinas.txt", "w") or die("Erro ao abrir o arquivo para escrita");

    foreach ($disciplinasRestantes as $disciplina) {
        fwrite($arqDisc, $disciplina);
    }

    fclose($arqDisc);

    echo "Item com sigla " . $siglaExcluir . " foi excluído com sucesso.";
}

    // Processar confirmação de alteração
    if (isset($_POST['confirmarAlteracao'])) {
        $siglaAlterar = $_POST['siglaAlterarConfirmada'];
        $novoNome = $_POST['novoNome'];
        $novaSigla = $_POST['novaSigla'];
        $novaCarga = $_POST['novaCarga'];

        // Abrir o arquivo original para leitura
        $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");

        if (!$arqDisc) {
            exit("Falha ao abrir o arquivo");
        }

        // Array para armazenar disciplinas alteradas
        $disciplinasAlteradas = [];

        // Ler o arquivo e atualizar a disciplina com a sigla correspondente
        while (!feof($arqDisc)) {
            $line = fgets($arqDisc);
            $coluna = explode(";", $line);

            // Verifica se a linha foi dividida corretamente
            if (count($coluna) >= 3) {
                $nome = $coluna[0];
                $sigla = $coluna[1];
                $carga = $coluna[2];

                // Verifica se é a disciplina a ser alterada
                if (($sigla) === ($siglaAlterar)) {
                    // Atualiza os dados, incluindo a sigla
                    $disciplinasAlteradas[] = $novoNome . ";" . $novaSigla . ";" . $novaCarga;
                } else {
                    // Mantém a disciplina original
                    $disciplinasAlteradas[] = $line;
                }
            }
        }

        fclose($arqDisc);

        // Abrir o arquivo novamente para escrita, sobrescrevendo com disciplinas alteradas
        $arqDisc = fopen("disciplinas.txt", "w") or die("Erro ao abrir o arquivo para escrita");

        foreach ($disciplinasAlteradas as $disciplina) {
            fwrite($arqDisc, $disciplina);
        }

        fclose($arqDisc);

        echo "Item com sigla " . $siglaAlterar . " foi alterado com sucesso.";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="ListaTodos.css">
</head>
<body>

    <div class="voltar">
        <button><a href="http://localhost/3DAW/exercicio5/ex05.html">Voltar</a></button>
    </div>

<table>
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Sigla</th>
        <th>Carga Horaria</th>
    </tr>
    <?php foreach ($disciplinas as $disciplina): ?>
    <tr>
        <td><?php echo $disciplina['id']; ?></td>
        <td><?php echo $disciplina['nome']; ?></td>
        <td><?php echo $disciplina['sigla']; ?></td>
        <td><?php echo $disciplina['carga']; ?></td>
        <td>
            <form method="post" style="display: inline;">
                <input type="hidden" name="siglaExcluir" value="<?php echo $disciplina['sigla']; ?>">
                <input type="submit" name="excluir" value="Excluir" />
            </form>
        </td>
        <td>
            <form method="post" style="display: inline;">
                <input type="hidden" name="siglaAlterar" value="<?php echo $disciplina['sigla']; ?>">
                <input type="submit" name="alterar" value="Alterar" />
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
// Exibir formulário de confirmação caso a exclusão tenha sido solicitada
if (isset($_POST['excluir'])) {
    $siglaExcluir = $_POST['siglaExcluir'];
?>
    <form method="post" style="margin-top: 20px;">
        <p>Tem certeza que deseja excluir a disciplina com a sigla: <?php echo $siglaExcluir; ?>?</p>
        <input type="hidden" name="siglaExcluirConfirmada" value="<?php echo $siglaExcluir; ?>">
        <input type="submit" name="confirmarExclusao" value="Confirmar Exclusão">
    </form>
<?php
}
?>

<?php
    // Exibir formulário de alteração caso a alteração tenha sido solicitada
    if (isset($_POST['alterar'])) {
        $siglaAlterar = $_POST['siglaAlterar'];
?>
    <form method="post" style="margin-top: 20px;">
        <p>Altere os dados da disciplina com a sigla: <?php echo $siglaAlterar; ?></p>
        <input type="hidden" name="siglaAlterarConfirmada" value="<?php echo $siglaAlterar; ?>">
        <label for="novoNome">Novo Nome:</label>
        <input type="text" name="novoNome" required><br><br>
        <label for="novaSigla">Nova Sigla:</label>
        <input type="text" name="novaSigla" required><br><br>
        <label for="novaCarga">Nova Carga Horária:</label>
        <input type="text" name="novaCarga" required><br><br>
        <input type="submit" name="confirmarAlteracao" value="Confirmar Alteração">
    </form>
<?php
}
?>


</body>
</html>