<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';


if (!isset($_SESSION['autenticado'] )) {
    header('Location: index.php');
    exit();
}

$usuario = new Usuario($db);
$usuarios = $usuario->listarTodos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $usuario->deletar($_POST['id']);
        header("Location: gerenciarUsuarios.php");
        exit();
    }
}
$termo = $_GET['pesquisa'] ?? '';
$usuarios = $usuario->pesquisarUsuarios($termo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <link rel="stylesheet" href="./styles/style_gUsuario.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <header>
        <img src="./assets/img/logo.png" alt="Logo" class="small-img">
        <h1 class="title">Gerenciamento de Usuário</h1>
        <a href="index.php" class="btn-voltar"><ion-icon name="arrow-undo"></ion-icon></a>
    </header>
    <main>
        <div class="container">
            <h1 class="title-container">Usuários</h1>
            <form method="GET">
                <div class="row">
                    <input type="text" name="search" placeholder="Pesquisar por nome ou e-mail" class="control">
                    <button type="submit" class="btn-pesquisa"><ion-icon name="search" style="font-weight: 900;"></ion-icon></button>
                </div>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td><?php echo $user['nome']; ?></td>
                            <td><?php echo $user['tipo']; ?></td>
                            <td>
                                <div class="row">
                                    <a href="deletarUsuario.php?id=<?php echo $user['id']; ?>" class="btn-excluir">Excluir
                                      <ion-icon name="trash"></ion-icon></a>
                                    <a href="editarUsuario.php?id=<?php echo $user['id']; ?>" class="btn-editar">Editar 
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