<?php
//verificar se não está logado
if (!isset($_SESSION["hqs"]["id"])) {
	exit;
}

include "functions.php";

if (!isset($id)) {
	$id = "";
}

// vai criar se não tiver id
$titulo = $data = $numero = $resumo = $capa = $valor = $tipo_id = $editora_id = $imagem = $nome = "";

if (!empty($id)) {

	$sql = "SELECT q.id, q.titulo, date_format(q.data, '%d/%m/%Y') dt,
	q.numero, q.resumo, q.capa, q.valor, q.tipo_id, q.editora_id, 
	t.tipo, 
	e.nome 
	FROM quadrinho q 
	INNER JOIN editora e ON (e.id = q.editora_id)
	INNER JOIN tipo t ON (q.tipo_id = t.id)
	WHERE q.id = :id LIMIT 1";

	$consulta = $pdo->prepare($sql);

	$consulta->bindParam(":id", $id);

	$consulta->execute();

	$dados = $consulta->fetch(PDO::FETCH_OBJ);

	// separar os dados
	$id         = $dados->id;
	$titulo     = $dados->titulo;
	$data       = $dados->dt;
	$numero     = $dados->numero;
	$resumo     = $dados->resumo;
	$capa       = $dados->capa; //apenas o valor
	$valor      = number_format($dados->valor, 2, ",", ".");
	$tipo_id    = $dados->tipo_id;
	$editora_id = $dados->editora_id;
	$nome		= $dados->nome;
	$tipo       = $dados->tipo;
	$imagem		= "../fotos/" . $capa . "p.jpg";
} else
	$id = '';

?>
<div class="container">
	<h1 class="float-left">Cadastro de Quadrinho</h1>
	<div class="float-right">
		<a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
		<a href="listar/quadrinho" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<form name="formCadastro" method="post" action="salvar/quadrinho" data-parsley-validate enctype="multipart/form-data">

		<div class="row">
			<div class="col-12 col-md-2">
				<label for="id">ID</label>
				<input type="text" id="id" name="id" readonly class="form-control" value="<?= $id; ?>">
			</div>

			<div class="col-12 col-md-10">
				<label for="titulo">Título do Quadrinho</label>
				<input type="text" id="titulo" name="titulo" class="form-control" required data-parsley-required-message="Por favor, preencha este campo" value="<?= $titulo; ?>">
			</div>

			<div class="col-12 col-md-6">
				<label for="tipo_id">Tipo de Quadrinho </label>
				<select name="tipo_id" id="tipo_id" class="form-control" required data-parsley-required-message="Selecione uma opção">
					<option value="">
						<?php
						if (!empty($tipo)) {
							echo $tipo;
						} ?>
					</option>

					<?php

					$sql = "SELECT id, tipo FROM tipo ORDER BY tipo";

					$consulta = $pdo->prepare($sql);

					$consulta->execute();

					while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
						//separar os dados
						$tipo_id	= $d->id;
						$tipo		= $d->tipo;

						echo '<option value="' . $tipo_id . '">' . $tipo . '</option>';
					}

					?>
				</select>
			</div>

			<div class="col-12 col-md-6">
				<!-- Listar editora -->
				<label for="editora_id">Editora</label>
				<input type="text" id="editora_id" name="editora_id" class="form-control" list="listaEditoras" 
				required data-parsley-required-message="Seleciona uma editora">
				<option value="">
					<?php
					if (!empty($editora_id)) {
						echo "$nome - $editora_id";
					} ?>
				</option>

				<datalist id="listaEditoras">

					<?php
					$sql = "SELECT id, nome FROM editora ORDER BY nome";

					$consulta = $pdo->prepare($sql);
					$consulta->execute();

					while ($d = $consulta->fetch(PDO::FETCH_OBJ)) {
						//separar os dados
						$editora_id 	= $d->id;
						$nome 			= $d->nome;
						// vai mostrar um dropdown com o id e nome da editora para fazer o autocomplete
						echo '<option value="' . $id . '">' . $nome . ' </option>';
					}
					?>

				</datalist>
			</div>

			<div class="col-12 col-md-3">
				<label for="numero">Número da Edição</label>
				<input type="text" id="numero" name="numero" class="form-control" required data-parsley-required-message="Preencha este campo" value="<?= $numero ?>">
			</div>

			<div class="col-12 col-md-3">
				<label for="data">Data de Lançamento</label>
				<input type="text" id="data" name="data" class="form-control" required data-parsley-required-message="Preencha este campo" value="<?= $data ?>">
			</div>

			<div class="col-12 col-md-3">
				<label for="valor">Valor</label>
				<input type="text" id="valor" name="valor" class="form-control" required data-parsley-required-message="Preencha este campo" value="<?= $valor ?>">
			</div>

			<div class="col-12 col-md-12">
				<label for="resumo">Resumo/Descrição</label>
				<textarea id="resumo" name="resumo" class="form-control" required data-parsley-required-message="Preencha este campo"><?= $resumo ?>></textarea>
			</div>

			<div class="col-12 col-md-12">
				<!-- Cadastrar capa -->
				<?php
				// só mostra que é required se for novo
				$r = ' required data-parsley-required-message="Selecione uma foto"';

				// se não estiver vazio, vai editar
				if (!empty($id)) $r = '';

				?>

				<label for="capa">Capa do Quadrinho</label>
				<input type="hidden" name="capa" value="<?= $capa; ?>">
				<input type="file" id="capa" name="capa" class="form-control" accept=".jpeg, .jpg" <?= $r; ?>>

				<?php
				if (!empty($capa)) {
					echo "<img src='$imagem' alt='$titulo' width='100px'>";
				}
				?>

				<br>

			</div>

			<button type="submit" class="btn btn-success margin">
				<i class="fas fa-check"></i> Gravar Dados
			</button>
	</form>

</div>

	<hr>
	<?php
		// verificar se estiver sendo editado para incluir formQ
		if ( !empty ( $id ) ) include "cadastro/formQuadrinho.php";
	?>

<script>
	$(document).ready(function() {

		$('#resumo').summernote();

		$('#valor').maskMoney({
			// modo de separar o valor
			thousands: ".",
			decimal: ","
		});

		$('#data').inputmask("99/99/9999");

		$('#numero').inputmask("9999");
	});
</script>