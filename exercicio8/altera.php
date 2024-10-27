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

    // Captura os dados do formulário
    $idAlterar = $data['id'] ?? null;
    $novaPergunta = $data["novaPergunta"] ?? null;
    $novaOpcaoA = $data["novaOpcaoA"] ?? null;
    $novaOpcaoB = $data["novaOpcaoB"] ?? null;
    $novaOpcaoC = $data["novaOpcaoC"] ?? null;
    $novaOpcaoD = $data["novaOpcaoD"] ?? null;
    $opcaoCerta = $data["novaOpcaoCerta"] ?? null;

    // Verifica se o ID e as novas informações da pergunta foram fornecidos
    if ($idAlterar && $novaPergunta && $novaOpcaoA && $novaOpcaoB && $novaOpcaoC && $novaOpcaoD && $opcaoCerta) {
        // Prepara o comando SQL para atualizar a pergunta com base no ID
        $stmt = $conn->prepare("UPDATE Perguntas SET questao = ?, opcaoA = ?, opcaoB = ?, opcaoC = ?, opcaoD = ?, opcaoCerta = ? WHERE id_perguntas = ?");
        $stmt->bind_param("ssssssi", $novaPergunta, $novaOpcaoA, $novaOpcaoB, $novaOpcaoC, $novaOpcaoD, $opcaoCerta, $idAlterar);

        // Executa a atualização e verifica se foi bem-sucedida
        if ($stmt->execute()) {
            http_response_code(200);
            echo "Pergunta atualizada com sucesso.";
        } else {
            http_response_code(500);
            echo "Erro ao atualizar a pergunta: " . $conn->error;
        }

        // Fecha o statement
        $stmt->close();
    } else {
        http_response_code(400);
        echo "Dados incompletos para atualização.";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    // Responde com um erro caso a requisição não seja POST
    http_response_code(405);
    echo "Método não permitido";
}

$conn->close();
?>
