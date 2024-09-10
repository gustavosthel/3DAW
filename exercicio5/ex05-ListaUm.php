<?php
// Inicializa a variável para armazenar os dados da disciplina encontrada
$disciplinasEncontradas = [];
$siglaBuscar = '';
$id = 1;

// Processa o formulário de busca
if (isset($_POST['buscar'])) {
    $siglaBuscar = $_POST['siglaBuscar'];
    
    // Abre o arquivo para leitura
    $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir o arquivo");
    
    if ($arqDisc) {
        while (!feof($arqDisc)) {
            $line = fgets($arqDisc);
            $coluna = explode(";", $line);

            // Verifica se a linha foi dividida corretamente em pelo menos 3 colunas
            if (count($coluna) >= 3) {
                $nome = trim($coluna[0]);
                $sigla = trim($coluna[1]);
                $carga = trim($coluna[2]);

                // Verifica se a sigla corresponde à busca
                if ($sigla === $siglaBuscar) {
                    $disciplinasEncontradas[] = [
                        'id' => $id, // Coloque o ID apropriado aqui se necessário
                        'nome' => $nome,
                        'sigla' => $sigla,
                        'carga' => $carga
                    ];
                    $id++;
                }
            }
        }
        fclose($arqDisc);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="ListaUm.css">
</head>
<body>

    <div class="voltar">
        <button><a href="http://localhost/3DAW/exercicio5/ex05.html">Voltar</a></button>
    </div>

    <!-- Formulário para buscar uma disciplina pela sigla -->
    <form method="post" style="margin-bottom: 20px;">
        <label for="siglaBuscar">Buscar por Sigla:</label>
        <input type="text" id="siglaBuscar" name="siglaBuscar" value="<?php echo htmlspecialchars($siglaBuscar); ?>" required>
        <input type="submit" name="buscar" value="Buscar">
    </form>

    <!-- Tabela de disciplinas encontradas -->
    <table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Sigla</th>
            <th>Carga Horária</th>
        </tr>
        <?php if (empty($disciplinasEncontradas)): ?>
        <tr>
            <td colspan="4">Nenhuma disciplina encontrada.</td>
        </tr>
        <?php else: ?>
            <?php foreach ($disciplinasEncontradas as $disciplina): ?>
            <tr>
                <td><?php echo htmlspecialchars($disciplina['id']); ?></td>
                <td><?php echo htmlspecialchars($disciplina['nome']); ?></td>
                <td><?php echo htmlspecialchars($disciplina['sigla']); ?></td>
                <td><?php echo htmlspecialchars($disciplina['carga']); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

</body>
</html>