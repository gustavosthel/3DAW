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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição e converte o JSON em um array PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Captura o ID para exclusão
    $idExcluir = $data['idExcluirConfirmada'] ?? null;

    // Verifica se o ID foi fornecido
    if ($idExcluir === null) {
        http_response_code(400);
        echo json_encode(['error' => 'ID de exclusão não fornecido.']);
        exit();
    }

    // Prepara o comando SQL para excluir a pergunta com base no ID
    $stmt = $conn->prepare("DELETE FROM Perguntas WHERE id_perguntas = ?");
    $stmt->bind_param("i", $idExcluir);

    // Executa a exclusão e verifica se foi bem-sucedida
    if ($stmt->execute()) {
        http_response_code(200);
        echo "Pergunta excluída com sucesso.";
    } else {
        http_response_code(500);
        echo "Erro ao excluir a pergunta: " . $conn->error;
    }

    // Fecha o statement e a conexão com o banco de dados
    $stmt->close();
    $conn->close();
} else {
    // Responde com um erro caso a requisição não seja POST
    http_response_code(405);
    echo "Método não permitido";
}

$conn->close();
?>
