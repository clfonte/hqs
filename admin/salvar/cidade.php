<?php
    //verificar se não está logado
    if (!isset($_SESSION["hqs"]["id"])) {
        exit;
    }

    if ($_POST) {

        $id = $cidade = $estado = "";

        foreach ($_POST as $key => $value) {

            $$key = trim($value);
        }

        if (empty($cidade)) {
            echo '<script>alert("Preencha o nome da cidade");history.back();</script>';
            exit;
        }
        
        else if (empty($estado)) {
            echo '<script>alert("Preencha o estado da cidade");history.back();</script>';
            exit;
        }
    }

    if (empty( $id ) ) {
        $sql = "INSERT INTO cidade (cidade, estado)	VALUES ( ?, ? )";
        
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $cidade);
        $consulta->bindParam(2, $estado);
        
	} else {
		$sql = "UPDATE cidade SET cidade = ?, estado = ? WHERE id = ? LIMIT 1";
          
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1, $cidade);
		$consulta->bindParam(2, $estado); 
		$consulta->bindParam(3, $id); 
    }
    
	if ( $consulta->execute() ) {
		echo '<script>alert("Registro Salvo");location.href="listar/cidade";</script>';
	} else {
		echo '<script>alert("Erro ao salvar");history.back();</script>';
		exit;
    } 