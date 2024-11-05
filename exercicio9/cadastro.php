<?php 

// Configuração de conexão com o banco de dados
$servidor = "localhost";
$username = "root";
$senha = "";
$database = "ex09";

// Cria a conexão com o banco de dados
$conn = new mysqli($servidor, $username, $senha, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lê o corpo da requisição e converte o JSON em um objeto PHP
    $data = json_decode(file_get_contents('php://input'));

    // Captura os dados do JSON
    $nome = trim($data->nome ?? '');
    $email = trim($data->email ?? '');
    $senha = trim($data->senha ?? '');

    // Verificação de campos vazios
    if (empty($nome) || empty($email) || empty($senha)) {
        http_response_code(400);
        echo json_encode(["erro" => "Todos os campos devem ser preenchidos."]);
        $conn->close();
        exit;
    }

    // Validação do nome (3-20 caracteres, sem espaços)
    if (strlen($nome) < 3 || strlen($nome) > 20 || preg_match('/\s/', $nome)) {
        http_response_code(400);
        echo json_encode(["erro" => "O nome deve ter entre 3 e 20 caracteres e não pode conter espaços."]);
        $conn->close();
        exit;
    }

    // Validação do formato do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(["erro" => "O email deve estar no formato válido."]);
        $conn->close();
        exit;
    }

    // Validação da senha (não pode ter 4 caracteres repetidos seguidos)
    if (preg_match('/(.)\1{3}/', $senha)) {
        http_response_code(400);
        echo json_encode(["erro" => "A senha não pode conter 4 caracteres repetidos em sequência."]);
        $conn->close();
        exit;
    }

    // Se todas as validações passarem, insere o usuário no banco de dados
    $comandoSQL = "INSERT INTO Usuarios (nome, email, senha) VALUES (?, ?, ?)";

    // Prepara a consulta para evitar SQL Injection
    $stmt = $conn->prepare($comandoSQL);
    $stmt->bind_param("sss", $nome, $email, $senha);

    // Executa a consulta
    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["mensagem" => "Usuário salvo com sucesso!"]);
    } else {
        http_response_code(500);
        echo json_encode(["erro" => "Erro ao salvar o usuário: " . $conn->error]);
    }

    // Fecha o statement
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();

?>
