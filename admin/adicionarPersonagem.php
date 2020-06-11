<!-- tem que adicionar o session start quando não estiver sendo include -->
<?php
    session_start();

    include "config/conexao.php";

    // verificar se foi dado post
    if ( $_POST ) {
        print_r($_POST);
        $personagem_id  = $_POST["personagem_id"] ?? "";
        $quadrinho_id   = $_POST["quadrinho_id"] ?? "";

        if ( empty( $personagem_id) or (empty( $quadrinho_id) ) );
        echo "<scrip>alert('Erro ao adicionar personagem');</script>";
    } else {
        // adicionar into quadrinho_personagem
        $sql = "INSERT INTO quadrinho_personagem VALUES(:quadrinho_id,:personagem_id)";

        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":quadrinho_id", $quadrinho_id);
        $consulta->bindParam(":personagem_id", $personagem_id);

        if ( !$consulta->execute() ) {
            echo "<script>alert('Não foi possível inserir o personagem neste quadrinho');</script>";
            echo $consulta->errorInfo()[2];
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personagem</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="vendor/jquery/jquery.min.js"></script>

</head>
<body>
    <h4>Personagens deste quadrinho</h4>
</body>
</html>