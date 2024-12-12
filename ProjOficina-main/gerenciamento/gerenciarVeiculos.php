<?php
session_start();
include_once '../config/config.php';
include_once '../classes/Veiculos.php';
include_once '../classes/Clientes.php';

if (!isset($_SESSION['autenticado'])) {
    header('Location: ../login.php');
    exit();
}

$veiculo = new Veiculo($db);
$veiculos = $veiculo->listarTodos();

$cliente = new Cliente($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $veiculo->deletar($_POST['id']);
        header("Location: ./gerenciarVeiculos.php");
        exit();
    }
}

$termo = $_GET['pesquisa'] ?? '';
$veiculos = $veiculo->pesquisarVeiculos($termo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Veículos</title>
    <link rel="stylesheet" href="../styles/style_gUsuario.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <header>
        <img src="../assets/img/logo.png" alt="Logo" class="small-img">
        <h1 class="title">Gerenciamento de Veículos</h1>
        <a href="../index.php" class="btn-voltar"><ion-icon name="arrow-undo"></ion-icon></a>
    </header>
    <main>
        <div class="container">
            <h1 class="title-container">Veículos</h1>
            <form method="GET">
                <div class="row">
                    <div class="search" style="margin-right: 20px">
                        <input type="text" name="pesquisa" class="input" placeholder="Procure por nome...">
                        <button class="search__btn">
                            <ion-icon name="search" style="font-weight: 900;"></ion-icon>
                        </button>
                    </div>
                    <a href="../cadastro/cadVeiculo.php" class="btn-adicionar"><ion-icon name="add-circle"></ion-icon></a>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Proprietário</th>
                        <th>Modelo</th>
                        <th>Placa</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($veiculos as $veic): ?>
                        <tr>
                            <?php 
                                // Buscar o cliente associado ao veículo
                                $clienteDados = $cliente->lerPorId($veic['fkCliente']);
                            ?>
                            <td><?php echo $clienteDados['nome']; ?></td>
                            <td><?php echo $veic['modelo']; ?></td>
                            <td><?php echo $veic['placa']; ?></td>
                            <td>
                                <div class="row">
                                    <form action="gerenciarVeiculos.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                        <input type="hidden" name="id" value="<?php echo $veic['id']; ?>">
                                        <button type="submit" name="delete" class="btn-excluir">
                                            Excluir <ion-icon name="trash"></ion-icon>
                                        </button>
                                    </form>
                                    <a href="../editar/editarVeiculo.php?id=<?php echo $veic['id']; ?>" class="btn-editar">Editar 
                                      <ion-icon name="pencil"></ion-icon></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
