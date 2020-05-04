<?php
    if (isset($_SESSION['hqs']['id'])) {
        exit;
    }

    //verificar se o id esta vazio
    if (empty($id)) {
        echo "<script>alert('Não foi possível excluir a editora selecionada.');history.back();</script>";
        exit;
    }

    //verificar se tem algum quadrinho 'ramificado' desta editora
    $sql = "select id from quadrinho where editora_id = ? limit 1";

    $consulta = $pdo->prepare($sql);
    
    //passar o id do parâmetro | off: parâmetros são os valores de referência
    $consulta->bindParam(1, $id);

    $consulta->execute();

    //recupera os dados desejados
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    //se tiver um quadrinho relacionado vai impedir de excluir e voltar
    if (!empty($dados->id)) {
        echo "<script>alert('Não foi possível excluir pois possui um quadrinho relacionado');history.back();</script>";
        exit;
    }

    // excluir a editora
    $sql = "delete from editora where id = ? limit 1";

    $consulta = $pdo->prepare($sql);

    $consulta->bindParam(1, $id);

    // verificar se nao executou
    if (!$consulta->execute()) {
        
        // captura erros
        // $erro = $consulta->errorInfo();
        // $erro = $consulta->errorInfo()[2];
        // print_r($erro);

        echo "<script>alert('Erro ao excluir');history.back();</script>";
        exit;
    }

    echo "<script>alert('Editora deletada com sucesso.');history.back;<script>";