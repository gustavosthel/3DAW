<?php

    $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");

    while(!feof($arqDisc)) {

        $line = fgets($arqDisc);

        if (!empty($line)) {
            $coluna = explode(";", $line);

            // Verifica se a linha foi dividida corretamente em pelo menos 4 colunas
            if (count($coluna) >= 6) {
                $perguntas[] = [
                    'id' => $coluna[0],
                    'questao' => $coluna[1],
                    'A' => $coluna[2],
                    'B' => $coluna[3],
                    'C' => $coluna[4],
                    'D' => $coluna[5],
                    'resposta' => $coluna[6]
                ];
            }
        }
    }

    fclose($arqDisc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Alunos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Questão</th>
                <th>Letra A</th>
                <th>Letra B</th>
                <th>Letra C</th>
                <th>Letra D</th>
                <th>Resposta</th>
                <th>Açoes</th>
            </tr>
            <?php if (!empty($perguntas)): ?>
            <?php foreach ($perguntas as $pergunta): ?>
            <tr>
                <td><?php echo $pergunta['id']; ?></td>
                <td><?php echo $pergunta['questao']; ?></td>
                <td><?php echo $pergunta['A']; ?></td>
                <td><?php echo $pergunta['B']; ?></td>
                <td><?php echo $pergunta['C']; ?></td>
                <td><?php echo $pergunta['D']; ?></td>
                <td><?php echo $pergunta['resposta']; ?></td>
                <td>
                    <form method="get">
                        <input type="hidden" name="idExcluir" value="<?php echo $pergunta['id']; ?>">
                        <input type="submit" name="excluir" value="Excluir" />
                    </form>
                </td>
                <td>
                    <form method="get">
                        <input type="hidden" name="idAlterar" value="<?php echo $pergunta['id']; ?>">
                        <input type="submit" name="alterar" value="Alterar" />
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhuma pergunta encontrado</td>
                </tr>
            <?php endif; ?>
        </table>

        <?php
            // Exibir formulário de alteração caso a alteração tenha sido solicitada
            if (isset($_GET['alterar'])) {
                $idAlterar = $_GET['idAlterar'];
        ?>
        <form method="post" action="altera.php" class="forms">
            <h3>Alterar Pergunta</h3>
            <input type="hidden" name="id" value="<?php echo $idAlterar ?>">
            <label>Questão:</label>
            <input type="text" name="novaPergunta" required><br>
            <label>Letra A:</label>
            <input type="text" name="novoA" required><br>
            <label">Letra B:</label>
            <input type="text" name="novoB" required><br>
            <label>Letra C:</label>
            <input type="text" name="novoC" required><br>
            <label>Letra D:</label>
            <input type="text" name="novoD" required><br>
            <h2>Escolher o Gabarito</h2>
            <label>Opção A</label>
            <input type="radio" value="A" name="novaOpcaoCerta"><br>
            <label>Opção B</label>
            <input type="radio" value="B" name="novaOpcaoCerta"><br>
            <label>Opção C</label>
            <input type="radio" value="C" name="novaOpcaoCerta"><br>
            <label>Opção D</label>
            <input type="radio" value="D" name="novaOpcaoCerta"><br>
            <input type="submit" name="confimarAlteracoes" value="Salvar Alterações">
        </form>
        <?php
        }
        ?>

        <?php
        // Exibir formulário de confirmação caso a exclusão tenha sido solicitada
        if (isset($_GET['excluir'])) {
            $idExcluir = $_GET['idExcluir'];
        ?>
            <form method="post" action="excluir.php" class="forms">
                <h3>Tem certeza que deseja excluir a pergunta com o Id: <?php echo $idExcluir; ?>?</h3>
                <input type="hidden" name="idExcluirConfirmada" value="<?php echo $idExcluir; ?>">
                <input type="submit" name="confirmarExclusao" value="Confirmar Exclusão">
            </form>
        <?php
        }
        ?>
    </div>
</body>
</html>