<?php
include 'config.php'; // Conexão com o banco de dados

// Consulta para pegar os fornecedores
$sql = "SELECT * FROM fornecedores";
$result = $conn->query($sql);

$fornecedores = [];

if ($result && $result->rowCount() > 0) {  // Alterado para PDO, usando rowCount()
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $fornecedores[] = $row;
    }
} 

// Lógica para inserção no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $endereco = $_POST["endereco"];

    // Verifique se todas as variáveis estão preenchidas
    if (empty($nome) || empty($telefone) || empty($email) || empty($endereco)) {
        echo "Por favor, preencha todos os campos.";
    } else {
        // Inserir no banco de dados
        $sql = "INSERT INTO fornecedores (nome, telefone, email, endereco) VALUES (:nome, :telefone, :email, :endereco)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':endereco', $endereco);

        if ($stmt->execute()) {
            // Sucesso
            header("Location: fornecedores.php");
            exit();
        } else {
            echo "Erro ao cadastrar fornecedor.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<style>
    :root {
        --bg-purple: #4A148C;
        --deep-purple: #3c096c;
        --text-white: #fff;
        --border-color: #ddd;
        --font-size-logo: 1.5rem;
        --font-weight-bold: bold;
        --font-size-base: 0.875rem;
        --padding-top-sidebar: 0;
        --margin-bottom-logo: 20px;
        --icon-size-small: 16px;
        --icon-size-medium: 24px;
        --icon-size-large: 32px;
    }

    body {
        font-size: var(--font-size-base);
    }

    .container {
        width: 100%;
        max-width: 800px;
        padding: 20px;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-bottom: 20px;
    }

    h2 {
        font-weight: 500;
        color: white;
        text-align: center;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: center;
    }

    .form-group, .mb-3 {
        display: flex;
        flex-direction: column;
        width: 100%;
        max-width: 600px;
        text-align: left;
    }

    input, select {
        padding: 10px;
        font-size: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: #f9f9f9;
        width: 100%;
    }

    button {
        padding: 12px;
        font-size: 1rem;
        color: var(--text-white);
        background-color: var(--bg-purple);
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.3s ease;
        width: 100%;
        max-width: 600px;
        margin-top: 20px;
    }

    button:hover {
        background-color: var(--deep-purple);
    }

   
    .btn-primary:hover {
        background-color: var(--deep-purple);
        border-color: var(--bg-purple);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 14px;
        text-align: center;
        border: 1px solid var(--border-color);
    }

  
    td {
        background-color: #f9f9f9;
    }

    .sidebar {
        background-color: var(--bg-purple);
        height: auto;
        padding-top: var(--padding-top-sidebar);
    }

    .sidebar .logo {
        position: relative;
        text-align: center;
        color: var(--text-white);
        font-size: var(--font-size-logo);
        font-weight: bolder;
        padding: 15px;
        background-color: var(--deep-purple);
    }

    .sidebar .nav-link {
        color: var(--text-white);
        font-weight: 500;
        display: flex;
        align-items: center;
        margin-top: 15px;
    }

    .sidebar .nav-link.active {
        color: var(--text-white);
    }

    .sidebar .nav-link:not(.active):hover {
        background-color: var(--deep-purple);
        border-radius: 15px;
    }

    .sidebar .nav-link span {
        margin-left: 10px;
    }

    .sidebar-sticky {
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: 0.5rem;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .form-group label {
        font-weight: var(--font-weight-bold);
    }

    .icon-small {
        font-size: var(--icon-size-small);
    }

    .icon-medium {
        font-size: var(--icon-size-medium);
    }

    .icon-large {
        font-size: var(--icon-size-large);
    }

    .user {
        list-style-type: none;
        margin-top: 40px;
        margin-left: 15px;
        color: var(--text-white);
    }

    .card-user {
        background-color: var(--deep-purple);
        padding: 4px 10px;
        width: 140px;
        border-radius: 15px;
    }

    .users {
        font-size: var(--icon-size-large);
    }

    .flex {
        display: flex;
        gap: 17px;
    }

    .flex .form-group select, .flex .form-group input {
        width: 600px;
    }

  

    .main-form {
        margin-top: 5%;
        margin-left: 0%;
    }

    label {
        font-size: 20px;
    }

    .main-title {
        margin-bottom: 4%;
    }

    .card {
        margin-bottom: 4%;
    }

    
    @media (max-width: 1200px) {
        .sidebar .logo {
            font-size: calc(var(--font-size-logo) * 0.9);
            padding: 12px;
        }
    }

    @media (max-width: 992px) {
        .sidebar .logo {
            font-size: calc(var(--font-size-logo) * 0.8);
            padding: 10px;
        }
    }

    @media (max-width: 768px) {
        .sidebar .logo {
            font-size: calc(var(--font-size-logo) * 0.7);
            padding: 8px;
        }
    }

    @media (max-width: 576px) {
        .sidebar .logo {
            font-size: calc(var(--font-size-logo) * 0.6);
            padding: 6px;
        }
    }
</style>

</head>

<body>
    <!--NÃO ALTERAR-->
    <div class="container-fluid">
        <div class="row">
              <nav class="col-md-2 d-none d-md-block bg-purple sidebar">
                <div class="logo text-center py-4">
                   
                    <h2>HORIZON+</h2>
                </div>
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="produtos.php">
                               
                                <i class="bi bi-phone-fill icon-large"></i>
                                <span>Produtos</span>
                             
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="pedidos.php"><i class="bi bi-basket2-fill icon-large"></i> Pedidos</a></li>
                        <li class="nav-item"><a class="nav-link" href="fornecedores.php"><i class="bi bi-people-fill icon-large"></i> Fornecedores</a></li>
                        <li class="nav-item"><a class="nav-link" href="funcionarios.php"><i class="bi bi-person-badge-fill icon-large"></i> Funcionários</a></li>
                        <li class="nav-item"><a class="nav-link" href="estoque.php"><i class="bi bi-box-fill icon-large"></i> Estoque</a></li>
                        <li class="nav-item"><a class="nav-link" href="manutencao.php"><i class="bi bi-pc-display-horizontal icon-large"></i> Manutenção</a></li>
                    </ul>
                    <div class="user mt-4">
                        <div class="nav-item text-center">
                            <div class=>
                                
                                <div class="ml-2">
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

           
            
               <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="container">
                    <h1 class="h2">Cadastro de Fornecedores</h1>
                </div>

                <div class="container">
                    <form id="fornecedorForm" action="fornecedores.php" method="POST">
                        <div class="form-section">
                            <div class="form-group">
                                <label for="Nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="nome" id="Nome" required>
                            </div>

                            <div class="form-group">
                                <label for="Telefone" class="form-label">Telefone</label>
                                <input type="tel" class="form-control" name="telefone" id="Telefone" required>
                            </div>

                            <div class="form-group">
                                <label for="Email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="Email" required>
                            </div>

                            <div class="form-group">
                                <label for="Endereco" class="form-label">Endereço</label>
                                <input type="text" class="form-control" name="endereco" id="Endereco" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Endereço</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($fornecedores) > 0): ?>
                                <?php foreach ($fornecedores as $fornecedor): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($fornecedor['fornecedor_id']) ?></td>
                                        <td><?= htmlspecialchars($fornecedor['nome']) ?></td>
                                        <td><?= htmlspecialchars($fornecedor['telefone']) ?></td>
                                        <td><?= htmlspecialchars($fornecedor['email']) ?></td>
                                        <td><?= htmlspecialchars($fornecedor['endereco']) ?></td>
                                        <td>
                                            <a href="update_fornecedores.php?id=<?= $fornecedor['fornecedor_id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="delete_fornecedores.php?id=<?= $fornecedor['fornecedor_id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Nenhum fornecedor cadastrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            $('#Telefone').mask('(00) 00000-0000');
                        });
                    </script>

                </main>
            </div>
        </div>
    </div>
</body>

</html>