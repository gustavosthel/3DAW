<?php

    // Inicializa a variável de mensagem
    $msg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Captura os dados do formulário diretamente, sem verificar isset 
        // Gera um ID único para o aluno
        $id = uniqid();
        $nome = $_POST["nome"];
        $cpf = $_POST["cpf"];
        $matricula = $_POST["matricula"];
        $data = $_POST["data"];

        // Verifica se os campos não estão vazios
        if (!empty($nome) && !empty($cpf) && !empty($matricula) && !empty($data)) {

            // Tenta abrir o arquivo para escrita
            $arqDisc = fopen("alunos.txt", "a") or die("Erro ao criar arquivo");
            $linha = $id . ";" . $nome . ";" . $cpf . ";" . $matricula . ";" . $data ."\n";
            fwrite($arqDisc, $linha);
            fclose($arqDisc);

            $msg = "Aluno $nome Adicionado com sucesso!!!";
        } else {
            $msg = "Por favor, preencha todos os campos.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="voltar">
        <a href="http://localhost/3DAW/exercicio6/index.html"><button>Voltar</button></a>
    </div>

    <form action="Adicionar.php" method="POST" class="forms">
        <h2>Adiciona Aluno no Sistema</h2>
        <label>Nome</label>
        <input type="text" name="nome">
        <label for="">CPF</label>
        <input type="text" name="cpf">
        <label for="">Matricula</label>
        <input type="text" name="matricula">
        <label for="">Data de Nacimento</label>
        <input type="date" name="data">
        <input type="submit" value="Adiciona Novo Aluno">
    </form>
    <p><?php echo $msg ?></p>
</body>
</html>