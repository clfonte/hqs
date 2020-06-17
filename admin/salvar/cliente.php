    <?php
    // Verificar se não está logado
    if (!isset($_SESSION['hqs']['id'])) {
        exit;
    }

    if ($_POST) {

        print_r(($_POST));
        include "functions.php";
        include "config/conexao.php";

        $id = $nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco =
        $complemento = $bairro = $cidade = $cidade_id = $estado = $foto = $telefone = $celular = "";

        // serve para guardar todas as vars
        foreach ($_POST as $key => $value) {
            $$key = trim($value);
        }
        
        if (empty($nome)) {
            echo "<script>alert('Preencha o nome');history.back();</script>";
            exit;
        } else if (empty($cpf)) {
            echo "<script>alert('Preencha o CPF');history.back();</script>";
            exit;
        } else if (empty($datanascimento)) {
            echo "<script>alert('Preencha a data de nascimento');history.back();</script>";
            exit;
        } else if (empty($email)) {
            echo "<script>alert('Preencha o email');history.back();</script>";
            exit;
        } else if (empty($cep)) {
            echo "<script>alert('Preencha o CEP');history.back();</script>";
            exit;
        } else if (empty($endereco)) {
            echo   '<script>alert("Preencha o endereço");history.back();</script>';
            exit;
        }} else if (empty($complemento)) {
            echo '<script>alert("Preencha o complemento");history.back();</script>';
            exit;
        } else if (empty($bairro)) {
            echo '<script>alert("Preencha o bairro");history.back();</script>';
            exit;
        } else if (empty($celular)) {
            echo '<script>alert("Preencha o celular");history.back();</script>';
            exit;
        }

        $pdo->beginTransaction();

        // $datanascimento   = formatarDN($datanascimento);
        $arquivo = $nome . "-" . $id;

        if (empty($id)) {
            $sql = "INSERT INTO cliente
            (nome, cpf, datanascimento, email, senha, cep, endereco, complemento, bairro, cidade_id, foto, telefone, celular)
            VALUES (:nome, :cpf, :datanascimento, :email, :senha, :cep, :endereco, :complemento, :bairro, :cidade_id, :foto,
            :telefone, :celular)";

        $consulta = $pdo->prepare($sql);
        
		$consulta->bindParam(":nome", $nome);
		$consulta->bindParam(":cpf", $cpf);
		$consulta->bindParam(":datanascimento", $datanascimento);
		$consulta->bindParam(":email", $email);
		$consulta->bindParam(":senha", $senha);
		$consulta->bindParam(":cep", $cep);
		$consulta->bindParam(":endereco", $endereco);
		$consulta->bindParam(":complemento", $complemento);
		$consulta->bindParam(":bairro", $bairro);
		$consulta->bindParam(":cidade_id", $cidade_id);
		$consulta->bindParam(":foto", $foto);
		$consulta->bindParam(":telefone", $telefone);
		$consulta->bindParam(":celular", $celular);

        } else {

            if (!empty($_FILES["foto"]["name"]))
                $foto = $arquivo;

            $sql = "UPDATE cliente SET 
            nome        = :nome,
            cpf         = :cpf,
            datanascimento  = :datanascimento,
            email       =: :email,
            senha       = :senha,
            cep         = :cep,
            endereco    = :endereco,
            complemento = :complemento,
            bairro      = :bairro,
            cidade_id   = :cidade_id,
            foto		= :foto,
			telefone	= :telefone,
			celular		= :celular 
            WHERE id = :id LIMIT 1";

            $consulta = $pdo->prepare($sql);

            
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":cpf", $cpf);
            $consulta->bindParam(":datanascimento", $datanascimento);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":senha", $senha);
            $consulta->bindParam(":cep", $cep);
            $consulta->bindParam(":endereco", $endereco);
            $consulta->bindParam(":complemento", $complemento);
            $consulta->bindParam(":bairro", $bairro);
            $consulta->bindParam(":cidade_id", $cidade_id);
            $consulta->bindParam(":foto", $foto);
            $consulta->bindParam(":telefone", $telefone);
            $consulta->bindParam(":celular", $celular);
            $consulta->bindParam(":id", $id);
        }

        // executar sql
        if ($consulta->execute()) {

        // verificar se o arquivo foi enviado
        if ((empty($_FILES["foto"]["type"])) AND (!empty($id))) {
			$pdo->commit();
			echo "<script>alert('Registro salvo');location.href='listar/cliente';</script>;";
            exit;
        }

            // verificar se o tipo de img é jpeg/jpg
            if ($_FILES["foto"]["type"] != "image/jpeg") {
                echo "<script>alert('Selecione uma imagem JPG válida');history.back();</script>";
                exit;
            }
            // se der certo, copiar a img para o servidor
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/cliente/" . $_FILES["foto"]["name"])) {

                /// redimensionar imgs
                $pastaFotos =  "../fotos/clientes";
                $imagem     = $_FILES["foto"]["name"];
                $nome       = $arquivo;
                fotoCliente($pastaFotos, $imagem, $nome);

                //gravar no banco
                $pdo->commit();
                echo "<script>alert('Registro salvo.');location.href='listar/cliente';</script>";
                exit;
            }

            // erro ao gravar
            echo "<script>alert('Erro ao gravar ou enviar arquivo.');history.back();</script>";
            exit;
        }

    echo "<p class='alert alert-warning'>Erro ao realizar requisição.</p>";
    echo $consulta->errorInfo()[2];
    exit;
