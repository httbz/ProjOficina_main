<?php
include_once '../config/config.php';
include_once '../classes/Veiculos.php';
include_once '../classes/Clientes.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $veiculo = new Veiculo($db);

    $fkCliente = $_POST['fkCliente'];
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];

    $veiculo->registrar($fkCliente, $modelo, $marca, $ano, $placa);
    header('Location: ../gerenciamento/gerenciarVeiculos.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Cadastrar Veículo</title>

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
        <h1 class="le">Cadastro de Veículos</h1>
        <a href="../gerenciamento/gerenciarVeiculos.php" class="btn-voltar"><ion-icon name="arrow-undo"></ion-icon></a>
    </header>

    <main style="height: 100vh;">
        <div class="container">
            <h1 class="text-center">Cadastrar Veículo</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fkCliente">Proprietário:</label><br>
                            <select name="fkCliente" required class="form-control">
                                <option value="">Selecione o Proprietário:</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?php echo $cliente['id']; ?>">
                                        <?php echo htmlspecialchars($cliente['nome']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modelo">Modelo:</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Modelo..."
                                required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marca">Marca:</label>
                            <input type="text" name="marca" id="marca" class="form-control" placeholder="Marca..."
                                required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ano">Ano:</label>
                            <input type="text" name="ano" id="ano" class="form-control"
                                placeholder="Ex: 2009, 2011, 1979..." required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="placa">Placa:</label>
                            <input type="text" name="placa" id="placa" class="form-control"
                                placeholder="Ex: XXX111, ZZZ2Z22..." required>
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