<?php
    session_start();
    
    //verificar se não está logado
    if (!isset($_SESSION["hqs"]["id"])) {
        exit;
    }

    $cidade = $_GET["cidade"] ?? "";
    $estado = $_GET["estado"] ?? "";

    if ( (empty ( $cidade ) ) OR ( empty ( $estado ) ) ) {
        echo "ERRO";
    }

    include "config/conexao.php";

    $sql = "SELECT id FROM cidade WHERE cidade = :cidade AND estado = :estado LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":cidade", $cidade);
    $consulta->bindParam(":estado", $estado);
    $consulta->execute();

    $d = $consulta->fetch(PDO::FETCH_OBJ);

    if ( empty ( $d->id ) ) echo "ERRO";
    else echo $d->id;