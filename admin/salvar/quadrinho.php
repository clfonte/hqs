<?php
// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if ( $_POST ) {
    include "functions.php";

    //print_r ($_POST);
    foreach ( $_POST as $key => $value ) {
        $$key =trim ( $value );
    }

    // verificar se está em branco
    if ( empty ( $titulo) ) {
        echo "<scrip>alert('Preencha o título');history.back()</script>";
        exit;
    } else if ( empty ( $tipo_id ) ) {
        echo "<scrip>alert('Preencha o tipo de quadrinho');history.back()</script>";
        exit;
    }
    // iniciar transação
    // só grava no banco quando der commit
    $pdo->beginTransaction(); 

    // print_r( $_FILES);
    $data = formatar ( $data );
    $numero = retirar ( $numero );

    // não repetir nome da img
    echo $arquivo =  time()."-".$_SESSION["hqs"]["id"];

    if ( empty ( $id ) ) {
        // inserir
        $sql = "INSERT INTO quadrinho (titulo, numero, data, capa, resumo, valor, tipo_id, editora_id)
        VALUES (:titulo, :numero, :data, :capa, :resumo, :valor, tipo_id, :editora_id)";
    } else {
        // editar
    }

    exit;
}

echo "<p class='alert alert-warning'>Requisição inválida</p>";