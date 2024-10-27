function buscarPergunta() {
    const idPergunta = document.getElementById('idPergunta').value;
    
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText) {
                const pergunta = JSON.parse(this.responseText);
                renderizarUmaPergunta(pergunta); // Atualiza a pergunta na tabela
            } else {
                limparTabela(); // Limpa a tabela se a pergunta foi excluída
            }
        } else if (this.readyState === 4) {
            console.log("Erro na requisição: " + this.status);
        }
    };
    
    xmlhttp.open("POST", "listaUmaPergunta.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.send(JSON.stringify({ idPergunta: idPergunta }));
}

// Função para limpar a tabela se a pergunta não existir
function limparTabela() {
    const tabela = document.getElementById('tabela-perguntas').getElementsByTagName('tbody')[0];
    tabela.innerHTML = ''; // Limpa o conteúdo da tabela
}

document.getElementById('buscarPergunta').addEventListener('submit', function(event) {
    event.preventDefault(); // Impede o envio padrão do formulário
    buscarPergunta(); // Chama a função de busca
});

function renderizarUmaPergunta(pergunta) {
    const tabela = document.getElementById('tabela-perguntas').getElementsByTagName('tbody')[0];
    tabela.innerHTML = ''; // Limpa o conteúdo atual

    const row = tabela.insertRow();

    row.insertCell(0).innerHTML = pergunta.id;
    row.insertCell(1).innerHTML = pergunta.questao;
    row.insertCell(2).innerHTML = pergunta.A;
    row.insertCell(3).innerHTML = pergunta.B;
    row.insertCell(4).innerHTML = pergunta.C;
    row.insertCell(5).innerHTML = pergunta.D;
    row.insertCell(6).innerHTML = pergunta.resposta;

    // Cria o botão de alteração
    const btnAlterar = document.createElement('button');
    btnAlterar.className = "btn-alterar";
    btnAlterar.textContent = "Alterar";
    btnAlterar.setAttribute('data-pergunta', JSON.stringify(pergunta));

    btnAlterar.addEventListener('click', function(event) {
        event.preventDefault();
        abrirModalAlterar(this.getAttribute('data-pergunta'));
    });

    row.insertCell(7).appendChild(btnAlterar);

    // Cria o botão de exclusão
    const btnExcluir = document.createElement('button');
    btnExcluir.className = "btn-excluir";
    btnExcluir.textContent = "Excluir";
    btnExcluir.setAttribute('data-pergunta', JSON.stringify(pergunta));

    btnExcluir.addEventListener('click', function(event) {
        event.preventDefault();
        abrirModalExcluir(this.getAttribute('data-pergunta'));
    });

    row.cells[7].appendChild(btnExcluir);
}

// Evento para fechar o modal ao clicar fora do conteúdo do modal
window.onclick = function(event) {
    const modais = ["criarPergunta", "excluirPergunta", "alterarPergunta"]; // Adicione os IDs de todos os modais aqui

    modais.forEach(modalId => {
        const modal = document.getElementById(modalId);
        // Verifica se o modal está visível e se o clique foi fora do conteúdo
        if (modal && event.target === modal) {
            fecharModalAlterar();
            fecharModalExcluir();
        }
    });
};

// Fechar o modal ao pressionar a tecla Esc
document.addEventListener("keydown", function(event) {
    if (event.key === "Escape") {
        fecharModalAlterar();
        fecharModalExcluir();
    }
});

// Função para abrir o modal de alteração com os dados da pergunta
function abrirModalAlterar(perguntaJson) {
    const pergunta = JSON.parse(perguntaJson);

    const modal = document.getElementById("alterarPergunta");
    document.getElementById("alterar-id").value = pergunta.id;
    document.getElementById("alterar-questao").value = pergunta.questao;
    document.getElementById("alterar-opcaoA").value = pergunta.A;
    document.getElementById("alterar-opcaoB").value = pergunta.B;
    document.getElementById("alterar-opcaoC").value = pergunta.C;
    document.getElementById("alterar-opcaoD").value = pergunta.D;

    // Marcar a resposta certa com verificação de elemento
    const respostaCorreta = pergunta.resposta.trim().toUpperCase();
    const respostaCertaId = `alterar-resposta${respostaCorreta}`;
    document.getElementById(respostaCertaId).checked = true;

    modal.style.display = "flex";
}

// Função para fechar o modal de alteração
function fecharModalAlterar() {
    const modal = document.getElementById("alterarPergunta");
    modal.style.display = "none";
}

// Configura o evento para o formulário de alteração
document.getElementById("form-alterar-pergunta").addEventListener("submit", function(event) {
    event.preventDefault();

    // Coleta os dados do formulário de alteração
    const formData = new FormData(event.target);
    const perguntaAlteraData = Object.fromEntries(formData.entries());

    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            buscarPergunta(); // Recarrega a lista de perguntas
            fecharModalAlterar();
        } else if (this.readyState === 4) {
            console.log("Erro na requisição: " + this.status);
        }
    };

    xmlhttp.open("POST", "altera.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.send(JSON.stringify(perguntaAlteraData));
});

function abrirModalExcluir(perguntaJson) {
    const pergunta = JSON.parse(perguntaJson);
    const modal = document.getElementById("excluirPergunta");

    // Atualiza o conteúdo do h3 para incluir o ID da pergunta
    document.getElementById("exibir-id").innerText = `Tem certeza que deseja excluir a pergunta com o Id: ${pergunta.id}?`;
    
    // Define o valor do ID a ser excluído no campo oculto
    document.getElementById("idExcluir").value = pergunta.id;

    modal.style.display = "flex";
}

function fecharModalExcluir() {
    const modal = document.getElementById("excluirPergunta");
    modal.style.display = "none";
}

// Configura o evento para o formulário de exclusão
document.getElementById("form-excluir-pergunta").addEventListener("submit", function(event) {
    event.preventDefault();

    // Coleta os dados do formulário de exclusão
    const formData = new FormData(event.target);
    const idExcluir = Object.fromEntries(formData.entries()).idExcluirConfirmada;

    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            buscarPergunta(); // Recarrega a lista de perguntas
            fecharModalExcluir();
        } else if (this.readyState === 4) {
            console.log("Erro na requisição: " + this.status);
        }
    };

    xmlhttp.open("POST", "excluir.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");
    xmlhttp.send(JSON.stringify({ idExcluirConfirmada: idExcluir })); // Envio como objeto
});
