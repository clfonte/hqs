<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Listar Quadrinho</h1>
	<div class="float-right">
		<a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
		<a href="listar/quadrinho" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
                <td>ID</td>
                <td>Foto</td>
				<td>Nome do Quadrinho / Número</td>
				<td>Data</td>
                <td>Valor</td>
                <td>Editora</td>
                <td>Opções</td>
            </tr>
        </thead>
        
		<tbody>
            <?php
                $sql = "SELECT q.id, q.titulo, q.capa, q.valor, q.numero, date_format(q.data, '%d/%m/%y') dt, e.nome editora
                FROM quadrinho q 
                INNER JOIN editora e ON (e.id = q.editora_id)
                ORDER BY q.titulo";

                $consulta = $pdo->prepare($sql);
                $consulta->execute();

                // recuperar dados
                while ( $dados = $consulta->fetch(PDO::FETCH_OBJ ) ) {
                    $id     = $dados->id;
                    $titulo = $dados->titulo;
                    $capa   = $dados->capa;
                    $valor  = number_format($dados->valor,2,",",".");
                    $numero = $dados->numero;
                    $editora= $dados->editora;
                    $dt     = $dados->dt;

                    $imagem = "../fotos/" . $capa . "p.jpg";
                    
                    echo "<tr>
                        <td>$id</td>
                        <td>
                            <img src = '$imagem' alt= '$titulo' width= '50px'>
                        </td>
                        <td>$titulo</td>
                        <td>$dt</td>
                        <td>R$ $valor</td>
                        <td>$editora</td>
                        <td>
                            <a href='cadastro/quadrinho/$id' class='btn btn-success btn-sm'>
                                <i class='fas fa-edit'></i>
                            </a>

                            <a href='javascript:excluir ( $id )' class='bnt btn-danger btn-sm'>
                                <i class='fas fa-trash'></i>
                            </a>
                        </td>
                    </tr>";
                }
            ?>
        </tbody>

    </table>
</div>

<script>
    // função que pergunta antes de excluir
    function excluir ( id ) {
        if ( confirm ("Deseja excluir este quadrinho?") ) {
            // redirecionar para exclusão
            location.href = "excluir/quadrinho/" + id;
        }
    }
</script>