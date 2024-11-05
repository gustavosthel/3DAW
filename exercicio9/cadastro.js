document.getElementById("formsCadastro").addEventListener("submit", function(event) {
    event.preventDefault()

    // Limpa qualquer mensagem de erro anterior
    const mensagemErro = document.getElementById("mensagemErro")
    mensagemErro.textContent = ""

    const formData = new FormData(event.target);
    const userData = Object.fromEntries(formData.entries());

    // Configura a requisição AJAX
    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log("Cadastro realizado com sucesso: " + this.responseText);
            window.location.href = "menu.html";
        } else if (this.readyState === 4) {
            // Erro - exibe a mensagem de erro retornada pelo servidor
            const response = JSON.parse(this.responseText);
            mensagemErro.textContent = response.erro || "Erro desconhecido. Tente novamente.";
        }
    };

    xmlhttp.open("POST", "cadastro.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");

    // Envia os dados em formato JSON
    xmlhttp.send(JSON.stringify(userData));

})