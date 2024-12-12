<?php
session_start();
include_once '../config/config.php';
include_once '../classes/Usuario.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

$usuario = new Usuario($db);

// Verificar se o ID foi fornecido para edição
if (isset($_GET['id'])) {
    // Recupera os dados do usuário para edição
    $id = $_GET['id'];
    $dadosUsuario = $usuario->lerPorId($id);
} else {
    // Caso contrário, preenche com valores vazios para cadastro
    $dadosUsuario = [
        'nome' => '',
        'tipo' => '',
        'sexo' => '',
        'celular' => '',
        'email' => '',
        'dataNasc' => '',
        'cpf' => '',
        'endCidade' => '',
        'endBairro' => '',
        'endRua' => '',
        'endNum' => '',
        'endComplemento' => '',
        'senha' => ''
    ];
}

// Processa o formulário para cadastro ou edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $sexo = $_POST['sexo'];
    $dataNasc = $_POST['dataNasc'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $endCidade = $_POST['endCidade'];
    $endBairro = $_POST['endBairro'];
    $endRua = $_POST['endRua'];
    $endNum = $_POST['endNum'];
    $senha = $_POST['senha'];
    $endComplemento = $_POST['endComplemento'];

    if (isset($_GET['id'])) {
        // Se ID existe, é edição, então atualiza os dados
        $usuario->atualizar($id, $nome, $tipo, $sexo, $dataNasc, $celular, $email, $cpf, $endCidade, $endBairro, $endRua, $endNum, $endComplemento, $senha);
    } else {
        // Caso contrário, cria um novo usuário
        $usuario->registrar($nome, $tipo, $senha, $sexo, $dataNasc, $email, $endCidade, $endBairro, $endNum, $endComplemento, $celular, $cpf);
    }

    // Redireciona para a página de gerenciamento de usuários
    header('Location: ../gerenciamento/gerenciarUsuarios.php');
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
    <title>Editar Usuário</title>
</head>

<body>
<header>
        <img src="../assets/img/logo.png" alt="Logo" class="small-img">
        <h1 class="le">Edição de Usuários</h1>
        <a href="../gerenciamento/gerenciarUsuarios.php" class="btn-voltar"><ion-icon name="arrow-undo"></ion-icon></a>
    </header>
    <main>
        <div class="container mx-auto shadow algin-middle">
            <h1 class="text-center">Editar <?php echo htmlspecialchars(ucfirst($dadosUsuario['nome'])); ?></h1>
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <label>Tipo:</label>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" id="admin" name="tipo" value="admin" <?php echo $dadosUsuario['tipo'] == 'admin' ? 'checked' : ''; ?> required> Administrador
                            </label>
                            <label class="radio-inline">
                                <input type="radio" id="funcionario" name="tipo" value="funcionario" <?php echo $dadosUsuario['tipo'] == 'funcionario' ? 'checked' : ''; ?> required> Funcionário
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Sexo:</label>
                        <div class="form-group">
                            <label class="radio-inline">
                                <input type="radio" id="masculino" name="sexo" value="M" <?php echo $dadosUsuario['sexo'] == 'M' ? 'checked' : ''; ?> required> Masculino
                            </label>
                            <label class="radio-inline">
                                <input type="radio" id="feminino" name="sexo" value="F" <?php echo $dadosUsuario['sexo'] == 'F' ? 'checked' : ''; ?> required> Feminino
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome..."
                                required value="<?php echo htmlspecialchars($dadosUsuario['nome']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="senha">Senha:</label>
                            <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha..."
                                required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dataNasc">Data de Nascimento:</label>
                            <input type="date" name="dataNasc" id="dataNasc" class="form-control" required value="<?php echo htmlspecialchars($dadosUsuario['dataNasc']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cpf">Cpf:</label>
                            <input type="text" name="cpf" id="cpf" class="form-control"
                                oninput="applyMask(this, cpfMask)" placeholder="Cpf..." maxlength="14" required value="<?php echo htmlspecialchars($dadosUsuario['cpf']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="celular">Celular:</label>
                            <input type="text" name="celular" id="celular" class="form-control"
                                placeholder="Telefone..." maxlength="15" oninput="applyMask(this, phoneMask)" required value="<?php echo htmlspecialchars($dadosUsuario['celular']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="E-Mail..."
                                required value="<?php echo htmlspecialchars($dadosUsuario['email']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="endCidade">Cidade:</label>
                            <input type="text" name="endCidade" id="endCidade" class="form-control"
                                placeholder="Cidade..." required value="<?php echo htmlspecialchars($dadosUsuario['endCidade']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="endBairro">Bairro:</label>
                            <input type="text" name="endBairro" id="endBairro" class="form-control"
                                placeholder="Bairro..." required value="<?php echo htmlspecialchars($dadosUsuario['endBairro']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="endRua">Rua/Logradouro:</label>
                            <input type="text" name="endRua" id="endRua" class="form-control"
                                placeholder="Rua/Logradouro..." required value="<?php echo htmlspecialchars($dadosUsuario['endRua']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="endNum">Número:</label>
                            <input type="text" name="endNum" id="endNum" class="form-control" placeholder="Número..."
                                required value="<?php echo htmlspecialchars($dadosUsuario['endNum']); ?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="endComplemento">Complemento:</label>
                            <input type="text" name="endComplemento" id="endComplemento" class="form-control"
                                placeholder="Complemento..." required value="<?php echo htmlspecialchars($dadosUsuario['endComplemento']); ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-cad">
                <ion-icon name="pencil"></ion-icon> Atualizar
                </button>
            </form>
        </div>
    </main>
        <script>

        function applyMask(input, maskFunction) {
            input.value = maskFunction(input.value);
        }

        // Máscara para CPF
        function cpfMask(value) {
            return value
                .replace(/\D/g, '')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        }

        // Máscara para CEP
        function cepMask(value) {
            return value
                .replace(/\D/g, '')
                .replace(/(\d{5})(\d)/, '$1-$2');
        }

        // Máscara para Telefone
        function phoneMask(value) {
            return value
                .replace(/\D/g, '')
                .replace(/(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{5})(\d{1,4})$/, '$1-$2');
        }
    </script>
</body>

</html>