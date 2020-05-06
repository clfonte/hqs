<?php
// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if ( $_POST ) {
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

    exit;
}

echo "<p class='alert alert-warning'>Requisição inválida</p>";