<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if ($_POST) {
    $id = $tipo = '';

    foreach ($_POST as $key => $value) {
        $$key = trim($value);
    }

    if (empty($tipo)) {
        echo '<script>alert("Preencha o tipo de quadrinho");history.back();</script>';
        exit;
    }


    $sql = "select id from tipo where tipo = ? and id <> ? limit 1"; //nao vai deixar repetir nomes de outras ids

    $consulta = $pdo->prepare($sql);

    $consulta->bindParam(1, $id);
    $consulta->bindParam(2, $tipo);

    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (!empty($dados->id)) {
        echo '<script>alert("Tipo já existente");history.back();</script>';
        exit;
    }

    if (empty($id)) {
        $sql = "insert into tipo (tipo) values (?)";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(1, $tipo);
    } else {
        $sql = "update tipo set tipo = ? where id = ? limit 1";

        $consulta = $pdo->prepare($sql);

        $consulta->bindParam(1, $id);
        $consulta->bindParam(2, $tipo);
    }

    if ($consulta->execute()) {
        echo '<script>alert("SALVO");location.href="listar/tipo";</script>';
    } else {
        echo '<script>alert("ERRO");history.back();</script>';
    }
} else {
    echo '<script>alert("SEM REQUISIÇÃO")</script>';
}