<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

?>

<div class="container">
    <h1 class="float-left">Listar Tipo</h1>
    <div class="float-right">
        <a href="cadastro/tipo" class="btn btn-success">Novo Tipo</a>
        <a href="listar/tipo" class="btn btn-info">Listar Tipos</a>
    </div>

    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover" id="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "select * from tipo order by tipo";

            $consulta = $pdo->prepare($sql);
            $consulta->execute();

            while ($dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                $id     = $dados->id;
                $tipo   = $dados->tipo;

                echo
                    '<tr>
                        <td> ' . $id . ' </td>
                        <td> ' . $tipo . '</td>
                        <td> <a href="cadastro/tipo/' . $id . '" class="btn btn-success btn-sm"> <i class="fas fa-edit"></i> </a> </td>
                    </tr>';
            }
            ?>
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function() {

            // plugin do jquery para organizar dados da tabela com opção de busca e separar por quantidade de pages
            $('#tabela').DataTable({
                "language": {
                    "lengthMenu": "Display _MENU_ Registro não encontrado",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Página _PAGE_ de _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Busca",
                    "previous": "Anterior"
                }
            });
        })
    </script>

</div>