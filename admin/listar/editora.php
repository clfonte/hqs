<?php
// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

?>

<div class="container">
    <h1 class="float-left">Listar Editora</h1>
    <div class="float-right">
        <a href="cadastro/editora" class="btn btn-success">Novo Registro</a>
        <a href="listar/editora" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th> 
                <th>Nome da Editora</th>
                <th>Site da Editora</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // buscar as editoras em ordem alfabetica
            $sql = "select * from editora order by nome";
            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                // separar os dados
                $id = $dados->id;
                $nome = $dados->nome;
                $site = $dados->site;

                // mostrar na tela
                echo '<tr>
                        <td>' . $id . '</td>
                        <td>' . $nome . '</td>
                        <td>' . $site . '</td>
                        <td><a href="cadastro/editora/' . $id . '" class="btn btn-success btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm" title="Deletar" onclick="excluir(' . $id . ')"><i class="fas fa-trash"></i></button></td>
                      </tr>';
            }
            ?>
        </tbody>
    </table>

</div>

<!-- adicionando função de excluir -->
<script>
    // perguntar se quer excluir, se sim, encaminhar para o endereço de excluir
    const excluir = (id) => {
        // perguntar
        if (confirm(`Deseja excluir a editora ${id}?`)) {
            // direcionar para lixeira
            location.href = `excluir/editora/${id}`
        }
    }
</script>