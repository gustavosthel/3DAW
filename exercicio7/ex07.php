<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $matricula = $_GET["matricula"];
    $nome = $_GET["nome"];
    $senha = $_GET["senha"];

if (!file_exists("alunos.txt")) {
    $arqDisc = fopen("alunos.txt", "w") or die("Erro ao criar arquivo");
    $linha = "matricula;nome;senha\n";
    fwrite($arqDisc, $linha);
    fclose($arqDisc);
}

$arqDisc = fopen("alunos.txt", "a") or die("Erro ao abrir arquivo");

$linha = $matricula . ";" . $nome . ";" . $senha . "\n";
fwrite($arqDisc, $linha);
fclose($arqDisc);

echo "Aluno inserido com sucesso!";
}
?>
