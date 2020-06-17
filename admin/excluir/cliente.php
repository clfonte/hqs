<?php
// verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
  exit;
}

if (empty($id)) {
  echo "<script>alert('Não foi possível excluir o registro');history.back();</script>";
  exit;
}

// excluir cidade
$sql = "DELETE FROM cliente WHERE id = :id LIMIT 1";

$consulta = $pdo->prepare($sql);
$consulta->bindParam(":id", $id);

// verificar se nao executou
if (!$consulta->execute()) {

  echo "<script>alert('Erro ao excluir');javascript:history.back();</script>";
}

echo "<script>location.href='listar/cliente';</script>";
