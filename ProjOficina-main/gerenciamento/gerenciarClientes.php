<?php
session_start();
include_once '../config/config.php';
include_once '../classes/Clientes.php';


if (!isset($_SESSION['autenticado'])) {
    header('Location: index.php');
    exit();
}

$cliente = new Cliente($db);
$clientes = $cliente->listarTodos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $cliente->deletar($_POST['id']);
        header("Location: ./gerenciarClientes.php");
        exit();
    }
}
//$termo = $_GET['pesquisa'] ?? '';
//$clientes = $clientes->pesquisarcliente($termo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Clientes</title>
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
        <h1 class="title">Gerenciamento de Clentes</h1>
        <a href="../index.php" class="btn-voltar"><ion-icon name="arrow-undo"></ion-icon></a>
    </header>
    <main>
        <div class="container">
            <h1 class="title-container">Clientes</h1>
            <form method="GET">
                <div class="search" style="margin-right: 20px">
                    <input type="text" name="text" class="input" placeholder="Procure por nome...">
                    <button class="search__btn">
                        <ion-icon name="search" style="font-weight: 900;"></ion-icon>
                    </button>
                    <a href="../cadastro/cadClientes.php" class="btn-adicionar"><ion-icon
                            name="add-circle"></ion-icon></a>
                </div>

            </form>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cli): ?>
                        <tr>
                            <td><?php echo $cli['nome']; ?></td>
                            <td><?php echo $cli['email']; ?></td>
                            <td><?php echo $cli['celular']; ?></td>
                            <td>
                                <div class="row">
                                    <form action="gerenciarClientes.php" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                        <input type="hidden" name="id" value="<?php echo $cli['id']; ?>">
                                        <button type="submit" name="delete" class="btn-excluir">
                                            Excluir <ion-icon name="trash"></ion-icon>
                                        </button>
                                    </form>
                                    <a href="../editar/editarCliente.php?id=<?php echo $cli['id']; ?>" class="btn-editar">Editar
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