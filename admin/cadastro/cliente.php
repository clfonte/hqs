<?php

//VERIFICAR SE ESTÁ LOGADO
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

if (!isset($id)) $id = '';

$nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco = $complemento = $bairro = $cidade_id = $cidade =
    $foto = $telefone = $celular = $estado =  '';

if (!empty($id)) {
    $sql = "SELECT
            c.*,
            date_format(c.datanascimento, '%d/%m/%Y') datanascimento,
            ci.cidade,
            ci.estado
        FROM cliente c
        INNER JOIN cidade ci ON ci.id = c.cidade_id
        WHERE c.id = :id
        LIMIT 1";

    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $nome = $dados->nome;
    $cpf = $dados->cpf;
    $datanascimento = $dados->datanascimento;
    $email = $dados->email;
    $telefone = $dados->telefone;
    $celular = $dados->celular;
    $cep = $dados->cep;
    $cidade_id = $dados->cidade_id;
    $nome_cidade = $dados->cidade;
    $estado = $dados->estado;
    $endereco = $dados->endereco;
    $bairro = $dados->bairro;
    $complemento = $dados->complemento;
    $nome = $dados->nome;
    $foto = $dados->foto;

    $imagem = "../fotos/" . $foto . "p.jpg";
}

?>

<div class="container">
    <h1 class="floar-left">Cadastro de Clientes</h1>
    <div class="float-right">
        <a href="cadastro/cliente" class="btn btn-success">Novo Registro</a>
        <a href="listar/cliente" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>

    <form name="formCadastro" method="post" action="salvar/cliente" data-parsley-validate enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-md-2">
                <label for="id">ID</label>
                <input type="text" name="id" id="id" class="form-control" readonly value="<?= $id ?>">
            </div>

            <div class="col-12 col-md-10">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" 
                required data-parsley-required-message="Preencha o nome" value="<?= $nome ?>" placeholder="Preencha com nome completo">
            </div>

            <div class="col-12 col-md-4">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" onblur="verificarCpf(this.value)" class="form-control" 
                required data-parsley-required-message="Preencha o CPF" value="<?= $cpf ?>" placeholder="000.000.000-00">
            </div>

            <div class="col-12 col-md-4">
                <label for="datanascimento">Data de Nascimento</label>
                <input type="text" name="datanascimento" id="datanascimento" class="form-control" 
                required data-parsley-required-message="Preencha a data de nascimento" value="<?= $datanascimento ?>" placeholder="00/00/0000">
            </div>

            <?php
            $required = "required data-parsley-required-message='Selecione uma foto'";
            if (!empty($id)) $required = '';
            ?>

            <div class="col-10 col-md-3">
                <label for="foto">Foto (.JPG)</label>
                <input type="file" accept=".jpg" name="foto" id="foto" <?= $required ?> class="form-control" value="<?= $foto ?>">

                <input type="hidden" name="foto" value="<?= $foto ?>">
            </div>

            <div class="col-2 col-md-1">
                <?php
                if (!empty($foto)) {
                    echo "<img class='rounded-circle mt-4 shadow-sm' src='$imagem' width='50'><br>";
                }
                ?>
            </div>

            <div class="col-12 col-md-6">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" 
                placeholder="Telefone com DDD" value="<?= $telefone ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="celular">Celular</label>
                <input type="text" name="celular" id="celular" class="form-control" 
                required required data-parsley-required-message="Preencha o celular" placeholder="Celular com DDD" value="<?= $celular ?>">
            </div>

            <div class="col-12">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" 
                required data-parsley-required-message="Preencha o e-mail" 
                data-parsley-type-message="Digite um e-mail válido" placeholder="Digite o e-mail" value="<?= $email ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" 
                required data-parsley-required-message="Preencha a senha">
            </div>

            <div class="col-12 col-md-6">
                <label for="senha2">Confirme a Senha</label>
                <input type="password" id="senha2" onblur="verificarSenha()" class="form-control" 
                required data-parsley-required-message="Confirme a senha">
            </div>

            <div class="col-12 col-md-3">
                <label for="CEP">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control" 
                required required data-parsley-required-message="Preencha o CEP" value="<?= $cep ?>">
            </div>

            <div class="col-12 col-md-2">
                <label for="cidade_id">ID Cidade</label>
                <input type="text" name="cidade_id" id="cidade_id" class="form-control"
                required required data-parsley-required-message="Preencha a Cidade" readonly value="<?= $cidade_id ?>">
            </div>

            <div class="col-12 col-md-5">
                <label for="nome_cidade">Nome da Cidade</label>
                <input type="text" id="nome_cidade" class="form-control" value="<?= $nome_cidade ?>">
            </div>

            <div class="col-12 col-md-2">
                <label for="estado">Estado</label>
                <input type="text" id="estado" class="form-control" value="<?= $estado ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" id="endereco" class="form-control" value="<?= $endereco ?>">
            </div>

            <div class="col-12 col-md-4">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="<?= $bairro ?>">
            </div>

            <div class="col-12 col-md-2">
                <label for="complemento">Complemento</label>
                <input type="text" name="complemento" id="complemento" class="form-control" value="<?= $complemento ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-success my-3">
            <i class="fas fa-check"></i>
            Gravar Dados
        </button>
    </form>
</div>

<?php
if (empty($id)) $id = 0
?>

<script>
    $(document).ready(function() {
        $('#datanascimento').inputmask("99/99/9999")
        $('#cpf').inputmask("999.999.999-99")
        $('#telefone').inputmask("(99) 9999-9999")
        $('#celular').inputmask("(99) 99999-9999")
    })

    function verificarCpf(cpf) {
        // Função Ajax para verificar o CPF
        $.get("verificarCpf.php", {
                cpf: cpf,
                id: <?= $id ?>
            },
            function(dados) {
                if (dados != '') {
                    // Mostrar o erro retornado
                    alert(dados)

                    // Zerar o CPF
                    $('#cpf').val('')
                }

            }
        )
    }

    $('#cep').blur(function() {
        // Pegar o CEP
        let cep = $('#cep').val()

        // Remover espaços e qualquer caractere que não seja dígito
        cep = cep.replace(/\D/g, '')

        // Verificar se está em branco
        if (cep == '') {
            alert('Preencha o CEP')
        } else {
            // Consultar o WEB SERVICE viacep.com.br
            $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                // Desestruturar objeto
                const {
                    localidade,
                    uf,
                    logradouro,
                    bairro
                } = dados

                // Consultar cidade no banco de dados
                $.get("verificarCidade.php", {
                        localidade,
                        uf
                    },
                    function(dados) {
                        // Verificar se retornou dados
                        if (!dados) return alert('Erro. ID da cidade não encontrado.')

                        // Converter em objeto
                        dados = JSON.parse(dados)

                        // Inserir id no input
                        $('#cidade_id').val(dados.id)
                    }
                )

                $('#nome_cidade').val(localidade)
                $('#estado').val(uf)
                $('#endereco').val(logradouro)
                $('#bairro').val(bairro)
            })
        }
    })

    function verificarSenha() {
        if ($('#senha').val() != $('#senha2').val()) {
            $('#senha').val('')
            $('#senha2').val('')
            $('#senha2').removeClass('is-valid')
            $('#senha2').addClass('is-invalid')
            return alert('As senhas devem ser iguais.')
        }

        $('#senha2').removeClass('is-invalid')
        $('#senha2').addClass('is-valid')
    }
</script>