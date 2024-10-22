<?php
    $sevidor = "localhost";
    $username = "admin";
    $senha = "";
    $database = "ex08";
    $con = new mysqli();

    if ($con -> connect_erro) {

    }

    $comandoSql = "INSERT INTO `Perguntas`(`pergunta`, `tipo`, `assunto`) VALUES ('Quem descobriu o Brasil?',1,'Historia')";
    //$resul = $con -> query($comandoSql); 



?>