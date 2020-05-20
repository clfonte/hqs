<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
    exit;
}

if (!isset($id)) $id = "";
    $nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco =
    $complemento = $bairro = $nome_cidade = $cidade_id = $foto = $telefone = $celular = "";

?>

<div class="container">
    <h1 class="float-left">Cadastro de Clientes</h1>
    <div class="float-right">
        <a href="cadastro/cliente" class="btn btn-success">Novo Registro</a>
        <a href="listar/cliente" class="btn btn-info">Listar Registros</a>
    </div>

    <div class="clearfix"></div>


    <!-- validar campos e não deixar em branco      | poder enviar algum arquivo de midia -->
    <form name="formCadastro" method="post" action="salvar/cliente" data-parsley-validate enctype="multipart/form-data">

        <div class="row">
            <div class="col-12 col-md-2">
                <label for="id">ID</label>
                <input type="text" id="id" name="id" class="form-control" readonly avlue="<?= $id; ?>">
            </div>

            <div class="col-12 col-md-10">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" 
                required data-parsley-message="Campo nome não pode ficar em branco" value="<?= $nome; ?>"
                placeholder="Preencha com seu nome completo">
            </div>

            <div class="col-12 col-md-4">
                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control" 
                required data-parsley-message="Preencha com um CPF válido" value="<?= $cpf; ?>"
                placeholder="Preencha com seu CPF">
            </div>

            <div class="col-12 col-md-4">
                <label for="datanascimento">Data de nascimento</label>
                <input type="text" id="datanascimento" name="datanascimento" class="form-control"
                required data-parsley-message="Preencha com sua data de nascimento" value="<?= $datanascimento; ?>"
                placeholder="Digita a data 00/00/0000">
            </div>

            <div class="col-12 col-md-4">
                <label for="foto">Foto (JPG)</label>
                <input type="file" id="foto" name="foto" class="form-control">
            </div>

            <div class="col-12 col-md-6">
                <label for="telefone">Tefelone</label>
                <input type="text" id="telefone" name="telefone" class="form-control" value="<?= $telefone; ?>"
                placeholder="Telefone com DDD">
            </div>

            <div class="col-12 col-md-6">
                <label for="celular">Celular</label>
                <input type="text" id="celular" name="celular" class="form-control"
                required data-parsley-required-message="Preencha o celular" value="<?= $celular; ?>"
                placeholder="Celular com DDD" >
            </div>

            <div class="col-12">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control"
                required data-parsley-required-message="Preencha o email" value="<?= $email; ?>"
                data-parsley-type-message="Preencha com um email válido">
            </div>

            <div class="col-6 col-md-6">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" class="form-control"> 
            </div>

            <div class="col-6 col-md-6">
                <label for="senha2">Confirme a senha</label>
                <input type="password" id="senha2" name="senha2" class="form-control"> 
            </div>

            <div class="col-12 col-md-3">
                <label for="cep">CEP</label>
                <input type="text" id="id" name="cep" class="form-control"
                required data-parsley-required-message="Preencha o CEP">
            </div>

            <div class="col-12 col-md-2">
                <label for="cidade_id">ID Cidade</label>
                <input type="text" id="cidade_id" name="cidade_id" class="form-control"
                required data-parsley-required-message="Preencha a cidade" readonly value="<?= $cidade_id; ?>">
            </div>

            <div class="col-12 col-md-6">
                <label for="nome_cidade">Nome da Cidade</label>
                <input type="text" id="nome_cidade" class="form-control" value="<?= $nome_cidade; ?>">
            </div>

        </div>

		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>
    </form>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#datanascimento').inputmask("99/99/9999");
            $('#cpf').inputmask("999.999.999-99");
            $('#telefone').inputmask("(99) 9999-9999");
            $('#celular').inputmask("(99) 99999-9999");
        })
    </script>
</div>