<?php

// Processa o formulário de busca
if (isset($_GET['buscar'])) {
    $matriculaBuscar = $_GET['matriculaBuscar'];
    
    // Abre o arquivo para leitura
    $arqDisc = fopen("alunos.txt", "r") or die("Erro ao abrir o arquivo");
    
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

            // Verifica se a sigla corresponde à busca
            if ($matricula === $matriculaBuscar) {
                $alunoEncontrado = [
                    'id' => $id, // Coloque o ID apropriado aqui se necessário
                    'nome' => $nome,
                    'cpf' => $cpf,
                    'matricula' => $matricula,
                    'data' => $data
                ];
            }
        }
    }
    fclose($arqDisc);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista um Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="voltar">
        <a href="http://localhost/3DAW/exercicio6/index.html"><button>Voltar</button></a>
    </div>

    <!-- Formulário para buscar um aluno pela matricula -->
    <form method="get" class="forms">
        <label>Buscar Aluno pela Matricula</label><br>
        <input type="text" name="matriculaBuscar" required>
        <input type="submit" name="buscar" value="Buscar">
    </form>

    <!-- Tabela de disciplinas encontradas -->
    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>Matricula</th>
            <th>Data de Naciento</th>
        </tr>
        <?php if (!empty($alunoEncontrado)): ?>
        <tr>
            <td><?php echo $alunoEncontrado['id']; ?></td>
            <td><?php echo $alunoEncontrado['nome']; ?></td>
            <td><?php echo $alunoEncontrado['cpf']; ?></td>
            <td><?php echo $alunoEncontrado['matricula']; ?></td>
            <td><?php echo $alunoEncontrado['data']; ?></td>
        </tr>
        <?php else: ?>
            <tr>
                <td colspan="5">Nenhum aluno encontrado</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>