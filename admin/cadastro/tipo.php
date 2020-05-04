<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

//começar minhas vars para insersão de novos cadastros
$tipo = "";

// se não existe id
if (!isset ( $id ) ) $id = "";

// verificar se existe id
if (!empty ( $id ) ) {
    $sql = "select * from tipo where id = ? limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);

    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    # PEGAR UM POR UM E SEPARAR
    $id     = $dados->id;
    $tipo   = $dados->tipo;
}

?>

<div class="container">
    <h1 class="float-left">Cadastro                                                                                                                                                          de Tipo</h1>
    <div class="float-right">
        <a href="cadastro/tipo" class="btn btn-success">Novo Tipo</a>
        <a href="listar/tipo" class="btn btn-info">Listar Tipos</a>
    </div>

    <div class="clearfix"></div>

    <form name="cadastro" method="post" action="salvar/tipo" data-parsley-validate>
        <label for="id">ID</label>
        <input type="text" class="form-control" name="id" id="id" readonly value="<?= $id ?>">

        <label for="tipo">Tipo</label>
        <input type="text" class="form-control" name="tipo" id="tipo" data-parsley-required-message="Preencha este campo" value="<?= $tipo ?>">

        <button type="submit" class="btn btn-success mt-3"><i class="fas fa-check"></i> Gravar Dados</button>
        </form>
</div>  