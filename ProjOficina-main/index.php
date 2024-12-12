<?php
session_start();
$_SESSION['autenticado'] = $_SESSION['usuario_id'];

include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);


if (isset($_SESSION['usuario_id'])) {
    $usuarios = $usuario->lerPorId($_SESSION['usuario_id']); 
} else {
    $usuarios = false; 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel="stylesheet" href="./styles/styleIndex.css">

    <title>Oficina</title>
</head>

<body class="text-white">
    <header class="container-fluid py-3 ">
        <div class="row align-items-center justify-content-between">
            <div class="col-auto">
                <img src="./assets/img/logo.png" alt="Logo" class="img-fluid" style="height: 65px; width: 65px;">
            </div>
            <div class="col text-center">
                <h1 class="h1 fw-bold m-0">OFICINA BGH</h1>
            </div>
            <div class="col-auto">
                <div class="dropdown">
                    <ion-icon name="person-circle" class="fs-1 dropdown-toggle" data-bs-toggle="dropdown"></ion-icon>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-item fw-bold h3"><?php echo ucfirst($usuarios['nome'])?></li>
                        <li><a class="dropdown-item" href="#">Gerenciar Conta</a></li>
                        <?php if ($usuarios && $usuarios['tipo'] === 'admin'): ?>
                            <li><a href="./gerenciamento/gerenciarUsuarios.php" class="dropdown-item">Gerenciar Usuários</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="logout.php">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main class="container py-5">
        <div class="row justify-content-center g-4 ">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">
                <a href="./gerenciamento/gerenciarVeiculos.php" class="text-decoration-none " style="transition: all 0.6s ease !important;">
                    <div class="test rounded-3 d-flex justify-content-center align-items-center shadow "
                        style="height: 250px;">
                        <ion-icon name="car-sport" id="img-anim"></ion-icon>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="./gerenciamento/gerenciarClientes.php" class="text-decoration-none">
                    <div class="test rounded-3 d-flex justify-content-center align-items-center shadow"
                        style="height: 250px;">
                        <ion-icon name="person" id="img-anim"></ion-icon>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="./gerenciamento/gerenciarServicos.php" class="text-decoration-none">
                    <div class="test rounded-3 d-flex justify-content-center align-items-center shadow"
                        style="height: 250px;">
                        <ion-icon name="hammer" id="img-anim"></ion-icon>
                    </div>
                </a>
            </div>

        </div>
        <div class="row justify-content-center g-4">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="./gerenciamento/gerenciarProdutos.php" class="text-decoration-none">
                    <div class="test rounded-3 d-flex justify-content-center align-items-center shadow"
                        style="height: 250px;">
                        <ion-icon name="pricetag" id="img-anim"></ion-icon>
                    </div>
                </a>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="./gerenciamento/gerenciarEstoque.php" class="text-decoration-none">
                    <div class="test rounded-3 d-flex justify-content-center align-items-center shadow"
                        style="height: 250px;">
                        <ion-icon name="logo-buffer" id="img-anim"></ion-icon>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function (e) {
            if (!e.target.matches('.dropbtn')) {
                var myDropdown = document.getElementById("myDropdown");
                if (myDropdown.classList.contains('show')) {
                    myDropdown.classList.remove('show');
                }
            }
        }
    </script>
</body>

</html>