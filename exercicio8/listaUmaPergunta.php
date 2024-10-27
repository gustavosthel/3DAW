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

// Verifica se um ID foi passado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição e converte o JSON em um array PHP
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $idBuscado = $data['idPergunta'] ?? null;

    if ($idBuscado === null) {
        http_response_code(400);
        echo json_encode(['error' => 'ID não fornecido']);
        exit();
    }

    // Comando SQL para buscar a pergunta pelo ID
    $comandoSQL = "SELECT id_perguntas, questao, opcaoA, opcaoB, opcaoC, opcaoD, opcaoCerta FROM Perguntas WHERE id_perguntas = ?";
    
    // Prepara a instrução SQL
    $stmt = $conn->prepare($comandoSQL);
    $stmt->bind_param("i", $idBuscado);
    $stmt->execute();
    
    // Obtém o resultado da consulta
    $resultado = $stmt->get_result();

    $pergunta = null;

    // Verifica se a pergunta foi encontrada
    if ($resultado->num_rows > 0) {
        $linha = $resultado->fetch_assoc();
        $pergunta = [
            'id' => $linha['id_perguntas'],
            'questao' => $linha['questao'],
            'A' => $linha['opcaoA'],
            'B' => $linha['opcaoB'],
            'C' => $linha['opcaoC'],
            'D' => $linha['opcaoD'],
            'resposta' => $linha['opcaoCerta']
        ];
    }

    // Fecha o statement
    $stmt->close();

    // Fecha a conexão com o banco de dados
    $conn->close();

    // Define o tipo de conteúdo da resposta como JSON
    header('Content-Type: application/json');

    // Retorna os dados da pergunta ou um erro se não encontrada
    if ($pergunta) {
        echo json_encode($pergunta);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Pergunta não encontrada']);
    }
} else {
    // Retorna um erro se a requisição não for POST
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
}
?>
