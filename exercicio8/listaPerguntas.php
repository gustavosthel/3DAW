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

// Comando SQL para buscar todas as perguntas
$comandoSQL = "SELECT id_perguntas, questao, opcaoA, opcaoB, opcaoC, opcaoD, opcaoCerta FROM Perguntas";
$resultado = $conn->query($comandoSQL);

$perguntas = [];

// Verifica se existem perguntas no resultado da consulta
if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $perguntas[] = [
            'id' => $linha['id_perguntas'],
            'questao' => $linha['questao'],
            'A' => $linha['opcaoA'],
            'B' => $linha['opcaoB'],
            'C' => $linha['opcaoC'],
            'D' => $linha['opcaoD'],
            'resposta' => $linha['opcaoCerta']
        ];
    }
}

// Fecha a conexão com o banco de dados
$conn->close();

// Retorna os dados em formato JSON
header('Content-Type: application/json');
echo json_encode($perguntas);
?>
