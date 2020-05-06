<?php

//arquivo para criar uma conexão com o banco de dados mysql
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "hqs";

try {
    //criar uma conexão PDO
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
} catch (PDOException $erro) {
    //mensagem de erro
    $msg = $erro->getMessage();

    echo "<p>Erro a conectar no banco de dados: $msg</p>";
}
