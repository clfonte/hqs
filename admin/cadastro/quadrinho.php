<?php
  //verificar se não está logado
  if ( !isset ( $_SESSION["hqs"]["id"] ) ){
    exit;
  }
?>
<div class="container">
	<h1 class="float-left">Cadastro de Quadrinho</h1>
	<div class="float-right">
		<a href="cadastro/quadrinho" class="btn btn-success">Novo Registro</a>
		<a href="listar/quadrinho" class="btn btn-info">Listar Registros</a>
	</div>

	<div class="clearfix"></div>

	<form name="formCadastro" method="post"
	action="salvar/quadrinho" data-parsley-validate enctype="multipart/form-data">

		<label for="id">ID</label>
		<input type="text" name="id" id="id" readonly class="form-control"
		value="<?=$id;?>">

		<label for="titulo">Título do Quadrinho</label>
		<input type="text" name="titulo" 
		id="titulo" class="form-control"
		required data-parsley-required-message="Por favor, preencha este campo"
		value="<?=$titulo;?>">

		<label for="tipo_id">Tipo de Quadrinho</label>
		<select name="tipo_id" id="tipo_id"
		class="form-control" required 
		data-parsley-required-message="Selecione uma opção">
			<option value=""></option>
			<?php
			$sql = "select id, tipo from tipo
			order by tipo";
			$consulta = $pdo->prepare($sql);
			$consulta->execute();

			while ( $d = $consulta->fetch(PDO::FETCH_OBJ) ){
				//separar os dados
				$id 	= $d->id;
				$tipo 	= $d->tipo;

				echo '<option value="'.$id.'">'.$tipo.'</option>';
			}

			?>
		</select>

		<label for="editora_id">Editora</label>
		<select name="editora_id" id="editora_id"
		class="form-control" required 
		data-parsley-required-message="Selecione uma editora">
			<option value=""></option>
			<?php
			$sql = "select id, nome from editora 
				order by nome";
			$consulta = $pdo->prepare($sql);
			$consulta->execute();

			while ( $d = $consulta->fetch(PDO::FETCH_OBJ) ) {
				//separar os dados
				$id 	= $d->id;
				$nome 	= $d->nome;
				echo '<option value="'.$id.'">'.$nome.'</option>';
			}
			?>
		</select>

		<label for="capa">Capa do Quadrinho</label>
		<input type="file" name="capa" id="capa"
		class="form-control" accept=".jpg">

		<label for="numero">Número</label>
		<input type="text" name="numero" id="numero"
		required data-parsley-required-message="Preencha este campo" class="form-control">

		<label for="data">Data de Lançamento</label>
		<input type="text" name="data" id="data"
		required data-parsley-required-message="Preencha este campo" class="form-control">

		<label for="valor">Valor</label>
		<input type="text" name="valor" id="valor"
		required data-parsley-required-message="Preencha este campo" class="form-control">

		<label for="resumo">Resumo/Descrição</label>
		<textarea name="resumo" id="resumo" required 
		data-parsley-required-message="Preencha este campo" class="form-control"></textarea>

		<button type="submit" class="btn btn-success margin">
			<i class="fas fa-check"></i> Gravar Dados
		</button>
	</form>

</div>