document.getElementById("formsUsuario").addEventListener("submit", function(event) {
    event.preventDefault();

    // Coleta os valores dos campos do formulário
    const formData = new FormData(event.target);
    const userData = Object.fromEntries(formData.entries());

    // Configura a requisição AJAX
    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log("Cadastro realizado com sucesso: " + this.responseText);
            window.location.href = "menu.html";
        } else if (this.readyState === 4) {
            console.log("Erro na requisição: " + this.status);
            window.location.href = "index.html";
        }
    };

    xmlhttp.open("POST", "cadastro.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/json");

    // Envia os dados em formato JSON
    xmlhttp.send(JSON.stringify(userData));
});
