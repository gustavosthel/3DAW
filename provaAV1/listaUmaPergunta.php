<?php

// Processa o formulário de busca
if (isset($_GET['buscar'])) {
    $idBuscar = $_GET['idBuscar'];
    
    // Abre o arquivo para leitura
    $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");
    
    while (!feof($arqDisc)) {
        $line = fgets($arqDisc);
        $coluna = explode(";", $line);

        // Verifica se a linha foi dividida corretamente em pelo menos 3 colunas
        if (count($coluna) >= 4) {
            $id = $coluna[0];
            $pergunta = $coluna[1];
            $A = $coluna[2];
            $B = $coluna[3];
            $C = $coluna[4];
            $D = $coluna[5];
            $perguntaCrto = $coluna[6];

            // Verifica se a sigla corresponde à busca
            if ($id === $idBuscar) {
                $perguntaEncontrada = [
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

    <!-- Formulário para buscar um aluno pela matricula -->
    <form method="get" class="forms">
        <label>Buscar pergunta pelo ID</label><br>
        <input type="text" name="idBuscar" required>
        <input type="submit" name="buscar" value="Buscar">
    </form>

    <!-- Tabela de disciplinas encontradas -->
    <table>
        <tr>
            <th>Id</th>
            <th>Questão</th>
            <th>Letra A</th>
            <th>Letra B</th>
            <th>Letra C</th>
            <th>Letra D</th>
            <th>Resposta</th>
        </tr>
        <?php if (!empty($perguntaEncontrada)): ?>
        <tr>
            <td><?php echo $perguntaEncontrada['id']; ?></td>
            <td><?php echo $perguntaEncontrada['questao']; ?></td>
            <td><?php echo $perguntaEncontrada['A']; ?></td>
            <td><?php echo $perguntaEncontrada['B']; ?></td>
            <td><?php echo $perguntaEncontrada['C']; ?></td>
            <td><?php echo $perguntaEncontrada['D']; ?></td>
            <td><?php echo $perguntaEncontrada['resposta']; ?></td>
        </tr>
        <?php else: ?>
            <tr>
                <td colspan="5">Nenhuma pergunta encontrado</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>