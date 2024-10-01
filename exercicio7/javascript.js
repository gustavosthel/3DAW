function adicionarAluno() {
    const matricula = document.getElementById("matricula").value
    const nome = document.getElementById("nome").value
    const senha = document.getElementById("senha").value
    const xmlhttp = new XMLHttpRequest()

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log("Chegou a resposta OK: " + this.responseText);
            document.getElementById("formsAluno").innerHTML = this.responseText;
        } else {
            console.log("Requisicao falhou: " + this.status);
        }
    }

    xmlhttp.open("GET", "http://localhost/3DAW/exercicio7/ex07.php=" + matricula +
                            "&nome=" + nome + "&email=" + senha);
    xmlhttp.send()
}