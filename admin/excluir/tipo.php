<?php
    // verificar se não está logado
    if ( !isset ($_SESSION["hqs"]["id"] ) ) {
        exit;
    }

    if (empty ($id)) {
        echo "<script>alert('Não foi possível excluir o registro');history.back();</script>";
        exit;
    }

    // verificar se tem quadrinho relacionado
    $sql = "SELECT id FROM quadrinho WHERE tipo_id = ? LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1,$id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    if (!empty ($dados->id)) {
        echo "<script>alert('Não é possível excluir pois existe um quadrinho relacionado.');history.back();</script>";
    }

    $sql = "DELETE FROM tipo WHERE id = ? LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);

    if (!$consulta->execute()){
        echo "<script>alert('Erro ao excluir');javascript:history.back();</script>";
    }

    echo "<script>location.href='listar/tipo'</script>";