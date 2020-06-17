<?php
    //verificar se não está logado
    if ( !isset ( $_SESSION["hqs"]["id"] ) ){
      exit;
    }

    if ( empty ( $id ) ) {
      echo "<script>alert('Não foi possível excluir o registro');history.back();</script>";
      exit;
    }

  $sql = "SELECT id FROM cliente WHERE cidade_id = ? LIMIT 1";
  //prepara a sql para executar
  $consulta = $pdo->prepare($sql);
  //passar o id do parametro
  $consulta->bindParam(1,$id);
  //executa o sql
  $consulta->execute();
  //recuperar os dados selecionados
  $dados = $consulta->fetch(PDO::FETCH_OBJ);

  if (!empty ($dados->id)) {
    echo "<script>alert('Não é possível excluir registro pois existe cliente relacionado.');history.back();</script>";
  }

  $sql = "DELETE FROM quadrinho WHERE id = ? LIMIT 1";

  $consulta = $pdo->prepare($sql);
  $consulta->bindParam(1, $id);
  //verificar se não executou
  if (!$consulta->execute()){
    echo "<script>alert('Erro ao excluir');javascript:history.back();</script>";
  }

  echo "<script>location.href='listar/quadrinho';</script>";
