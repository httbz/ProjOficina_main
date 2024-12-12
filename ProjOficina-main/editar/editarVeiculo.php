<?php
session_start();
include_once '../config/config.php';
include_once '../classes/Veiculos.php';
include_once '../classes/Clientes.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

$veiculo = new Veiculo($db);
$clientes = new Cliente($db);
$clientes = $clientes->ler();

// Verificar se o ID foi fornecido para edição
if (isset($_GET['id'])) {
    // Recupera os dados do veículo para edição
    $id = $_GET['id'];
    $dadosVeiculos = $veiculo->lerPorId($id);
    // Verificar se o veículo existe
    if (!$dadosVeiculos) {
        // Caso o veículo não exista, redirecionar ou mostrar erro
        header('Location: ../gerenciamento/gerenciarVeiculos.php');
        exit();
    }
} else {
    // Caso contrário, preenche com valores vazios para cadastro
    $dadosVeiculos = [
        'modelo' => '',
        'marca' => '',
        'placa' => '',
        'ano' => '',
        'fkCliente' => '',
    ];
}

// Processa o formulário para cadastro ou edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe os dados do formulário
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = $_POST['ano'];
    $fkCliente = $_POST['fkCliente'];
    $placa = $_POST['placa'];

    if (isset($_GET['id'])) {
        // Se ID existe, é edição, então atualiza os dados
        $veiculo->atualizar($id, $fkCliente, $modelo, $marca, $ano, $placa);
    } else {
        // Caso contrário, cria um novo veículo
        $veiculo->registrar($fkCliente, $modelo, $marca, $placa, $ano);
    }

    // Redireciona para a página de gerenciamento de veículos
    header('Location: ../gerenciamento/gerenciarVeiculos.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styleCadUsuario.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="../styles/styleCadUsuario.css">
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <title>Editar Veículo</title>
</head>
<body>
    <header>
        <img src="../assets/img/logo.png" alt="Logo" class="small-img">
        <h1 class="le">Edição de Veículos</h1>
        <a href="../gerenciamento/gerenciarVeiculos.php" class="btn-voltar"><ion-icon name="arrow-undo"></ion-icon></a>
    </header>
    <main>
        <div class="container">
            <h1 class="text-center">
                <?php if (isset($_GET['id'])): ?>
                    Editar Veículo: <?php echo htmlspecialchars($dadosVeiculos['placa']); ?>
                <?php else: ?>
                    Cadastrar Veículo
                <?php endif; ?>
            </h1>
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fkCliente">Proprietário:</label><br>
                            <select name="fkCliente" required class="form-control">
                                <option value="">Selecione o Proprietário:</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?php echo $cliente['id']; ?>" 
                                        <?php echo ($cliente['id'] == $dadosVeiculos['fkCliente']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cliente['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="modelo">Modelo:</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Modelo..."
                                value="<?php echo htmlspecialchars($dadosVeiculos['modelo']); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marca">Marca:</label>
                            <input type="text" name="marca" id="marca" class="form-control" placeholder="Marca..."
                                value="<?php echo htmlspecialchars($dadosVeiculos['marca']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ano">Ano:</label>
                            <input type="text" name="ano" id="ano" class="form-control"
                                placeholder="Ex: 2009, 2011, 1979..."
                                value="<?php echo htmlspecialchars($dadosVeiculos['ano']); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="placa">Placa:</label>
                            <input type="text" name="placa" id="placa" class="form-control"
                                placeholder="Ex: XXX111, ZZZ2Z22..."
                                value="<?php echo htmlspecialchars($dadosVeiculos['placa']); ?>" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-cad">
                    <i class="fa fa-plus"></i> 
                    <?php echo isset($_GET['id']) ? 'Atualizar' : 'Cadastrar'; ?>
                </button>
            </form>
        </div>
    </main>
</body>
</html>
