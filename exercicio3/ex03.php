<?php
    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Captura os dados do formulário diretamente, sem verificar isset
        $nome = $_POST["nome"];
        $sigla = $_POST["sigla"];
        $carga = $_POST["carga"];

        // Verifica se os campos não estão vazios
        if (!empty($nome) && !empty($sigla) && !empty($carga)) {
            // Exibe os valores capturados
            echo "Nome: " . htmlspecialchars($nome) . " Sigla: " . htmlspecialchars($sigla) . " Carga Horária: " . htmlspecialchars($carga);

            // Tenta abrir o arquivo para escrita
            $arqDisc = fopen("disciplinas.txt", "a") or die("Erro ao criar arquivo");
            $linha = $nome . ";" . $sigla . ";" . $carga . "\n";
            fwrite($arqDisc, $linha);
            fclose($arqDisc);

            $msg = "Deu tudo certo!!!";
        } else {
            $msg = "Por favor, preencha todos os campos.";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Criar Nova Disciplina</title>
</head>
<body>
    <h1>Criar Nova Disciplina</h1>
    <form action="ex03.php" method="POST">
        Nome: <input type="text" name="nome" required>
        <br><br>
        Sigla: <input type="text" name="sigla" required>
        <br><br>
        Carga Horária: <input type="text" name="carga" required>
        <br><br>
        <input type="submit" value="Criar Nova Disciplina">
    </form>
    <p><?php echo htmlspecialchars($msg); ?></p>
    <br>
</body>
</html>