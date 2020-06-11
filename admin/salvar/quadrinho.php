<?php
// Verificar se não está logado
if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// print_r($_POST);
// printf($_FILES);

if ( $_POST ) {
    include "functions.php";
    include "config/conexao.php";

    $id = $titulo = $data = $numero = $valor = $resumo = $tipo_id = $editora_id = $capa = "";

    //print_r ($_POST);
    foreach ( $_POST as $key => $value ) {
        $$key =trim ( $value );
    }

    // print_r ($_FILES); print_r ($_POST);

    // verificar se está em branco
    if ( empty ( $titulo) ) {
        echo "<scrip>alert('Preencha o título');history.back()</script>";
        exit;
    } else if ( empty ( $tipo_id ) ) {
        echo "<scrip>alert('Preencha o tipo de quadrinho');history.back()</script>";
        exit;
    }

    // iniciar transação
    // só grava no banco quando der commit
    $pdo->beginTransaction(); 

    // print_r( $_FILES);
    $data = formatar ( $data );
    $numero = retirar ( $numero );
    $valor = formatarValor ( $valor );

    // não repetir nome da img e colocar - id do usuário
    echo $arquivo =  time(). "-" . $_SESSION["hqs"]["id"];

    if ( empty ( $id ) ) {
        // inserir
        $sql = "INSERT INTO quadrinho 
        (titulo, numero, data, capa, resumo, valor, tipo_id, editora_id)
        VALUES 
        (:titulo, :numero, :data, :capa, :resumo, :valor, :tipo_id, :editora_id)";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":titulo", $titulo);
        $consulta->bindParam(":numero", $numero);
        $consulta->bindParam(":data", $data);
        $consulta->bindParam(":capa", $arquivo);
        $consulta->bindParam(":resumo", $resumo);
        $consulta->bindParam(":valor", $valor);
        $consulta->bindParam(":tipo_id", $tipo_id);
        $consulta->bindParam("editora_id", $editora_id);

    } else {
        // editar

        /* echo "<p>capa: $capa</p>";
        echo $_FILES["capa"]["name"]; */

        // qual arquivo/nome novo que será salvo
        if ( !empty ( $_FILES["capa"]["name"] ) )
            $capa = $arquivo; 

            /*nome que já vai gravar no banco
            echo "<p>capa: $capa</p>";*/

            $sql = "update quadrinho set 
            titulo = :titulo,
            numero = :numero,
            valor  = :valor,
            resumo = :resumo,
            capa   = :capa,
            tipo_id = :tipo_id,
            editora_id  = :editora_id,
            data   = :data
            where id = :id limit 1";

            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":titulo", $titulo);
            $consulta->bindParam(":numero", $numero);
            $consulta->bindParam(":valor", $valor);
            $consulta->bindParam(":resumo", $resumo);
            $consulta->bindParam(":capa", $capa);
            $consulta->bindParam(":tipo_id", $tipo_id,);
            $consulta->bindParam(":editora_id", $editora_id);
            $consulta->bindParam(":data", $data);
            $consulta->bindParam(":id", $id);
        }

    // executar sql
    if ( $consulta->execute() ) {

        // verificar se o tipo de img é jpeg/jpg
        if ( $_FILES["capa"]["type"] != "image/jpeg") {
           echo "<script>alert('Selecione uma imagem JPG válida');history.back();</script>";
           exit;
        }
        // se der certo, copiar a img para o servidor
        if ( move_uploaded_file ( $_FILES["capa"]["tmp_name"], "../fotos/".$_FILES["capa"]["name"] ) ) {

            /// redimensionar imgs
            $pastaFotos =  "../fotos/";
            $imagem     = $_FILES["capa"]["name"];
            $nome       = $arquivo;
            redimensionarImagem($pastaFotos, $imagem, $nome);

            //gravar no banco
            $pdo->commit();
            echo "<script>alert('Registro salvo.');location.href='listar/quadrinho';</script>";
            exit;
        }

        // erro ao gravar
        echo "<script>alert('Erro ao salvar ou enviar arquivo para o servidor.');history.back();</script>";
        exit;
    }
    echo $consulta->errorInfo()[2];

    exit;
}

echo "<p class='alert alert-warning'>Requisição inválida</p>";