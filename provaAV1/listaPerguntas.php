<?php

    $arqDisc = fopen("perguntas.txt", "r") or die("Erro ao abrir o arquivo");

    while(!feof($arqDisc)) {

        $line = fgets($arqDisc);

        if (!empty($line)) {
            $coluna = explode(";", $line);

            // Verifica se a linha foi dividida corretamente em pelo menos 6 colunas
            if (count($coluna) >= 6) {
                $perguntas[] = [
                    'id' => $coluna[0],
                    'questao' => $coluna[1],
                    'A' => $coluna[2],
                    'B' => $coluna[3],
                    'C' => $coluna[4],
                    'D' => $coluna[5],
                    'resposta' => $coluna[6]
                ];
            }
        }
    }

    fclose($arqDisc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Alunos</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <div class="voltar">
        <a href="http://localhost/3DAW/provaAV1/menu.html"><button>Voltar</button></a>
    </div>

    <div class="container">
        <div class="tabela">
            <h2>Lista de Perguntas</h2>
            <!-- Link para abrir o modal de criar -->
            <a href="#criarPergunta" class="btn-criar">Criar Pergunta +</a>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Questão</th>
                    <th>Letra A</th>
                    <th>Letra B</th>
                    <th>Letra C</th>
                    <th>Letra D</th>
                    <th>Resposta</th>
                    <th>Açoes</th>
                </tr>
                <?php if (!empty($perguntas)): ?>
                <?php foreach ($perguntas as $pergunta): ?>
                <tr>
                    <td><?php echo $pergunta['id']; ?></td>
                    <td><?php echo $pergunta['questao']; ?></td>
                    <td><?php echo $pergunta['A']; ?></td>
                    <td><?php echo $pergunta['B']; ?></td>
                    <td><?php echo $pergunta['C']; ?></td>
                    <td><?php echo $pergunta['D']; ?></td>
                    <td><?php echo $pergunta['resposta']; ?></td>
                    <td>
                        <!-- Link para abrir o modal de alterar -->
                        <a href="#alterar<?php echo $pergunta['id']; ?>" class="btn-alterar">Alterar</a>

                        <!-- Link para abrir o modal de excluir -->
                        <a href="#excluir<?php echo $pergunta['id']; ?>" class="btn-excluir">Excluir</a>
                    </td>
                </tr>

                <!-- Modal de Criar Pergunta -->
                <div id="criarPergunta" class="modal">
                    <div class="modal-content">
                        <form action="criar.php" method="POST">
                            <h3>Crie Sua Pergunta!</h3>
                            <input type="text" name="questao" placeholder="Digite qual sera a questão" required><br>
                            <input type="text" name="opcaoA" placeholder="Digite a opção da letra A" required><br>
                            <input type="text" name="opcaoB" placeholder="Digite a opção da letra B" required><br>
                            <input type="text" name="opcaoC" placeholder="Digite a opção da letra C" required><br>
                            <input type="text" name="opcaoD" placeholder="Digite a opção da letra D" required><br>
                            <h3>Escolher a Resposta Certa</h3>
                            <label>Opção A</label>
                            <input type="radio" value="A" name="opcaoCerta" required><br>
                            <label>Opção B</label>
                            <input type="radio" value="B" name="opcaoCerta" required><br>
                            <label>Opção C</label>
                            <input type="radio" value="C" name="opcaoCerta" required><br>
                            <label>Opção D</label>
                            <input type="radio" value="D" name="opcaoCerta" required><br>
                            <input type="submit" class="bnt-criarPerguntas" value="Criar">
                        </form>
                        <a href="#" class="close">Fechar</a>
                    </div>
                </div>

                <!-- Modal de alterar -->
                <div id="alterar<?php echo $pergunta['id']; ?>" class="modal">
                    <div class="modal-content">
                        <h3>Alterar Pergunta</h3>
                        <form method="post" action="altera.php">
                            <input type="hidden" name="id" value="<?php echo $pergunta['id']; ?>">
                            <input type="text" name="novaPergunta" placeholder="Digite qual sera a questão" required><br>
                            <input type="text" name="novoA" placeholder="Digite a opção da letra A" required><br>
                            <input type="text" name="novoB" placeholder="Digite a opção da letra B" required><br>
                            <input type="text" name="novoC" placeholder="Digite a opção da letra C" required><br>
                            <input type="text" name="novoD" placeholder="Digite a opção da letra D" required><br>
                            <h3>Escolher o Gabarito</h3>
                            <label>Opção A</label>
                            <input type="radio" value="A" name="novaOpcaoCerta"><br>
                            <label>Opção B</label>
                            <input type="radio" value="B" name="novaOpcaoCerta"><br>
                            <label>Opção C</label>
                            <input type="radio" value="C" name="novaOpcaoCerta"><br>
                            <label>Opção D</label>
                            <input type="radio" value="D" name="novaOpcaoCerta"><br>
                            <input type="submit" name="confirmarAlteracoes" class="bnt-salvaAlteracao" value="Salvar Alterações">
                        </form>
                        <a href="#" class="close">Fechar</a>
                    </div>
                </div>

                <!-- Modal de excluir -->
                <div id="excluir<?php echo $pergunta['id']; ?>" class="modal">
                    <div class="modal-content">
                        <h3>Tem certeza que deseja excluir a pergunta com o Id: <?php echo $pergunta['id']; ?>?</h3>
                        <form method="post" action="excluir.php">
                            <input type="hidden" name="idExcluirConfirmada" value="<?php echo $pergunta['id']; ?>">
                            <input type="submit" name="confirmarExclusao" class="bnt-confirmaExclusao" value="Confirmar Exclusão">
                        </form>
                        <a href="#" class="close">Fechar</a>
                    </div>
                </div>

                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Nenhuma pergunta encontrado</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>