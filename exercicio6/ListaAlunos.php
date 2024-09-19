<?php

    $arqDisc = fopen("alunos.txt", "r") or die("Erro ao abrir o arquivo");

    while(!feof($arqDisc)) {

        $line = fgets($arqDisc);

        if (!empty($line)) {
            $coluna = explode(";", $line);

            // Verifica se a linha foi dividida corretamente em pelo menos 4 colunas
            if (count($coluna) >= 4) {
                $alunos[] = [
                    'id' => $coluna[0],
                    'nome' => $coluna[1],
                    'cpf' => $coluna[2],
                    'matricula' => $coluna[3],
                    'data' => $coluna[4]
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

    <div class="voltar">
        <a href="http://localhost/3DAW/exercicio6/index.html"><button>Voltar</button></a>
    </div>

    <div class="container">
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Matricula</th>
                <th>Data de Naciento</th>
                <th>Excluir</th>
                <th>Alterar</th>
            </tr>
            <?php if (!empty($alunos)): ?>
            <?php foreach ($alunos as $aluno): ?>
            <tr>
                <td><?php echo $aluno['id']; ?></td>
                <td><?php echo $aluno['nome']; ?></td>
                <td><?php echo $aluno['cpf']; ?></td>
                <td><?php echo $aluno['matricula']; ?></td>
                <td><?php echo $aluno['data']; ?></td>
                <td>
                    <form method="get">
                        <input type="hidden" name="idExcluir" value="<?php echo $aluno['id']; ?>">
                        <input type="submit" name="excluir" value="Excluir" />
                    </form>
                </td>
                <td>
                    <form method="get">
                        <input type="hidden" name="idAlterar" value="<?php echo $aluno['id']; ?>">
                        <input type="submit" name="alterar" value="Alterar" />
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Nenhum aluno encontrado</td>
                </tr>
            <?php endif; ?>
        </table>

        <?php
            // Exibir formulário de alteração caso a alteração tenha sido solicitada
            if (isset($_GET['alterar'])) {
                $idAlterar = $_GET['idAlterar'];
        ?>
        <form method="post" action="altera.php" class="forms">
            <h3>Alterar Aluno</h3>
            <input type="hidden" name="id" value="<?php echo $idAlterar ?>">
            <label>Nome:</label>
            <input type="text" name="novoNome" required><br>
            <label>CPF:</label>
            <input type="text" name="novoCpf" required><br>
            <label">Matrícula:</label>
            <input type="text" name="novoMatricula" required><br>
            <label>Data de Nascimento:</label>
            <input type="date" name="novoData" required><br>
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
                <h3>Tem certeza que deseja excluir o aluno com o Id: <?php echo $idExcluir; ?>?</h3>
                <input type="hidden" name="idExcluirConfirmada" value="<?php echo $idExcluir; ?>">
                <input type="submit" name="confirmarExclusao" value="Confirmar Exclusão">
            </form>
        <?php
        }
        ?>
    </div>
</body>
</html>