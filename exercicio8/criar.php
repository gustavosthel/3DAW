<?php
// Configuração de conexão com o banco de dados
$servidor = "localhost";
$username = "root";
$senha = "";
$database = "ex08";

// Cria a conexão com o banco de dados
$conn = new mysqli($servidor, $username, $senha, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição e converte o JSON em um array PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Captura os dados do formulário
    $questao = $data["questao"] ?? null;
    $opcaoA = $data["opcaoA"] ?? null;
    $opcaoB = $data["opcaoB"] ?? null;
    $opcaoC = $data["opcaoC"] ?? null;
    $opcaoD = $data["opcaoD"] ?? null;
    $opcaoCerta = $data["opcaoCerta"] ?? null;

    // Verifica se os campos não estão vazios
    if (!empty($questao) && !empty($opcaoA) && !empty($opcaoB) && !empty($opcaoC) && !empty($opcaoD) && !empty($opcaoCerta)) {
        // Prepara o comando SQL para inserção
        $comandoSQL = "INSERT INTO Perguntas (questao, opcaoA, opcaoB, opcaoC, opcaoD, opcaoCerta) VALUES (?, ?, ?, ?, ?, ?)";

        // Prepara a consulta para evitar SQL Injection
        $stmt = $conn->prepare($comandoSQL);
        $stmt->bind_param("ssssss", $questao, $opcaoA, $opcaoB, $opcaoC, $opcaoD, $opcaoCerta);

        // Executa a consulta
        if ($stmt->execute()) {
            http_response_code(200);
            echo "Pergunta salva com sucesso!";
        } else {
            http_response_code(500);
            echo "Erro ao salvar a pergunta: " . $conn->error;
        }

        // Fecha o statement
        $stmt->close();
    } else {
        // Responde com um erro caso os campos estejam vazios
        http_response_code(400);
        echo "Preencha todos os campos.";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
