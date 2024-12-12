<?php
session_start();
include_once '../config/config.php';
include_once '../classes/Usuario.php';

if (!isset($_SESSION['autenticado'])) {
    header('Location: ../login.php');
    exit();
}

$usuario = new Usuario($db);

// Captura o termo de pesquisa (caso exista)
$termo = $_GET['pesquisa'] ?? '';

// Verifica se o termo de pesquisa foi fornecido. Se não, lista todos os usuários.
if ($termo) {
    $usuarios = $usuario->pesquisarUsuarios($termo); // Pesquisa os usuários com o termo
} else {
    $usuarios = $usuario->listarTodos(); // Lista todos os usuários caso não haja pesquisa
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $usuario->deletar($_POST['id']);
        header("Location: ./gerenciarUsuarios.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
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
        <h1 class="title">Gerenciamento de Usuário</h1>
        <a href="../index.php" class="btn-voltar"><ion-icon name="arrow-undo"></ion-icon></a>
    </header>
    <main>
        <div class="container">
            <h1 class="title-container">Usuários</h1>
            <form method="GET">
                <div class="row">
                    <div class="search" style="margin-right: 20px">
                        <input type="text" name="pesquisa" class="input" placeholder="Procure por nome..." value="<?php echo htmlspecialchars($termo); ?>">
                        <button class="search__btn">
                            <ion-icon name="search" style="font-weight: 900;"></ion-icon>
                        </button>
                    </div>
                    <a href="../cadastro/cadUsuario.php" class="btn-adicionar"><ion-icon name="add-circle"></ion-icon></a>
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
                    <!-- Exibe a mensagem de "nenhum usuário encontrado" se não houver resultados da pesquisa -->
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="3">Nenhum usuário encontrado para o termo "<?php echo htmlspecialchars($termo); ?>"</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['nome']); ?></td>
                                <td><?php echo htmlspecialchars($user['tipo']); ?></td>
                                <td>
                                    <div class="row">
                                        <form action="gerenciarUsuarios.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" name="delete" class="btn-excluir">
                                                Excluir <ion-icon name="trash"></ion-icon>
                                            </button>
                                        </form>
                                        <a href="../editar/editarUsuario.php?id=<?php echo $user['id']; ?>"
                                           class="btn-editar">Editar <ion-icon name="pencil"></ion-icon></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
