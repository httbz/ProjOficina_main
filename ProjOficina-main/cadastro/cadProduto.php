<?php
include_once '../config/config.php';
include_once '../classes/Produtos.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto = new Produtos ($db);

    $descricao = $_POST['descricao'];
    $valorCusto = $_POST['valorCusto'];
    $valorVenda = $_POST['valorVenda'];
    $referencia = $_POST['referencia'];
    

    $produto->registrar($descricao, $valorCusto, $valorVenda, $referencia);
    header('Location: ../gerenciamento/gerenciarProdutos.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Cadastrar Produto</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="../styles/styleCadUsuario.css">
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <header>
        <img src="../assets/img/logo.png" alt="Logo" class="small-img">
        <h1 class="le title-container">Cadastro de Produto</h1>
        <a href="../gerenciamento/gerenciarProdutos.php" class="btn-voltar"><ion-icon name="arrow-undo"></ion-icon></a>
    </header>

    <main>
        <br><br><br>
        <div class="container mx-auto shadow ">
            <h1 class="text-center title-container">Cadastrar Produtos</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Descrição:</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" placeholder="Descrição..."
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="senha">Valor de custo:</label>
                            <input type="text" name="valorCusto" id="valorCusto" class="form-control" placeholder="Valor de custo..."
                                required>
                        </div>
                    </div>
                  
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dataNasc">Valor de venda:</label>
                            <input type="text" name="valorVenda" id="valorVenda" class="form-control" required placeholder="Valor de venda...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="senha">Referencia:</label>
                            <input type="text" name="referencia" id="referencia" class="form-control" placeholder="Referecia..."
                                required>
                        </div>
                    </div>
                    </div>
                    

                               

                

                <button type="submit" class="btn-cad">
                    <i class="fa fa-plus"></i> Cadastrar
                </button>
            </form>
        </div>
    </main>

    <!-- Bootstrap JS, jQuery, and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 

</body>

</html>