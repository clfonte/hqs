<?php

    // evitar que entre na edição de quadrinho sem passar pela parte cadastro
    if ( !isset ( $pagina ) ) exit;
?>

<form name="formPersonagem" action="adicionarPersonagem.php" method="post"
data-parsley-validate="" target="personagens">
    <h3>Adicionar Personagens</h3>

    <input type="hidden" name="quadrinho_id" value="<?= $id; ?>">
    <div class="row">
        <div class="col-10">
            <select id="personagem_id" name="personagem_id" class="form-control"
            required data-parsley-required-message="Selecione um personagem">
                <option value="">Selecione um personagem</option>
                <?php
                    $sql = "SELECT id, nome FROM personagem ORDER BY nome";
                    $consulta = $pdo->prepare($sql);
                    $consulta->execute();

                    while ( $dados = $consulta->fetch(PDO::FETCH_OBJ)) {
                        // separar as vars 
                        $id_personagem  = $dados->id;
                        $nome = $dados->nome;

                        echo "<option value='$id_personagem'>$nome</option>";
                    }
                ?>
            </select>
        </div>

        <div class="col-4">
            <button type="submit" class="btn btn-success">Adicionar</button>
            <button type="reset" class="btn btn-danger">Novo</button> <!-- apagar todos que tiver -->
        </div>
    </div>
</form>

<!-- tela onde terá listado os personagens com opção de editar e excluir -->
<iframe name="personagens" width="100%" height="300px" scr="adicionarPersonagens.php"></iframe>