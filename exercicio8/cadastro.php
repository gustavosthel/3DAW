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

    // Captura os dados do JSON
    $nome = $data["nome"] ?? null;
    $email = $data["email"] ?? null;
    $senha = $data["senha"] ?? null;

    // Verifica se os campos não estão vazios
    if (!empty($nome) && !empty($email) && !empty($senha)) {
        // Prepara o comando SQL para inserção
        $comandoSQL = "INSERT INTO Usuarios (nome, email, senha) VALUES (?, ?, ?)";

        // Prepara a consulta para evitar SQL Injection
        $stmt = $conn->prepare($comandoSQL);
        $stmt->bind_param("sss", $nome, $email, $senha);

        // Executa a consulta
        if ($stmt->execute()) {
            http_response_code(200);
            echo "Usuário salvo com sucesso!";
        } else {
            http_response_code(500);
            echo "Erro ao salvar o usuário: " . $conn->error;
        }

        // Fecha o statement
        $stmt->close();
    } else {
        http_response_code(400);
        echo "Preencha todos os campos.";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
