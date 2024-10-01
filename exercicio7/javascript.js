document.getElementById("formsAluno").addEventListener("submit", function(event) {
    event.preventDefault();

    const matricula = document.getElementById("matricula").value;
    const nome = document.getElementById("nome").value;
    const senha = document.getElementById("senha").value;

    const xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Chegou a resposta OK: " + this.responseText);
            document.getElementById("formsAluno").innerHTML = this.responseText;
        } else if (this.readyState == 4) {
            console.log("Requisição falhou: " + this.status);
        }
    }

    xmlhttp.open("GET", "http://localhost/3DAW/exercicio7/ex07.php?matricula=" + matricula +
                            "&nome=" + nome + "&senha=" + senha, true);
    xmlhttp.send();
});
