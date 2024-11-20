<?php
include 'config.php';

// Ativar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os dados do pedido
    $sql = "SELECT * FROM pedidos WHERE pedido_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC); // Obtém os dados do registro

    // Verificar se o pedido foi encontrado
    if (!$row) {
        echo "Pedido não encontrado.";
        exit(); // Adicionar exit() para evitar que o restante da página seja executado
    }

    // Buscar os funcionários para exibir no formulário
    $sql_funcionarios = "SELECT funcionario_id, nome FROM funcionarios";
    $stmt_funcionarios = $conn->prepare($sql_funcionarios);
    $stmt_funcionarios->execute();
    $result_funcionarios = $stmt_funcionarios->fetchAll(PDO::FETCH_ASSOC);

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Coletar os dados do formulário e sanitizar
        $datahora_pedido = $_POST['datahora_pedido']; // formato 'YYYY-MM-DDTHH:MM'
        $status = htmlspecialchars($_POST['status']);
        $valor_total = $_POST['valor_total'];
        $funcionario_id = $_POST['funcionario_id'];

        // Atualizar os dados no banco de dados
        $sql_update = "UPDATE pedidos SET data_pedido = :data_pedido, status = :status, valor_total = :valor_total, funcionario_id = :funcionario_id WHERE pedido_id = :id";
        $stmt_update = $conn->prepare($sql_update);

        $stmt_update->bindParam(':data_pedido', $datahora_pedido); // Passando a data e hora completas
        $stmt_update->bindParam(':status', $status);
        $stmt_update->bindParam(':valor_total', $valor_total);
        $stmt_update->bindParam(':funcionario_id', $funcionario_id);
        $stmt_update->bindParam(':id', $id, PDO::PARAM_INT);

        // Executar a atualização
        if ($stmt_update->execute()) {
            // Redirecionar para o index.php após a atualização bem-sucedida
            header("Location: pedidos.php");
            exit(); // Certifique-se de que a execução do código pare aqui após o redirecionamento
        } else {
            echo "Erro ao atualizar os dados do pedido.";
            print_r($stmt_update->errorInfo()); // Adicione esta linha para ver o erro
        }
    }
} else {
    echo "ID não encontrado.";
    exit(); // Adicionar exit() para evitar que o restante da página seja executado
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ATUALIZAÇÃO  DE PEDIDOS</title>
    <link rel="stylesheet" href="src/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="src/css/styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
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

    .btn-primary {
        margin-top: 2%;
        width: 100%;
        background-color: var(--bg-purple);
        border-color: var(--deep-purple);
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

    th {
        background-color: var(--bg-purple);
        color: var(--text-white);
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

    .btn-create {
        margin-bottom: 1%;
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
            <h2 class="mt-5">Atualizar Pedido</h2>
            <form action="?id=<?php echo $row['pedido_id']; ?>" method="post">

            <div class="form-group">

                    <label for="datahora_pedido" class="form-label">Data e Hora do Pedido</label>
                    <!-- Juntando a data e hora para exibição -->
                    <input type="datetime-local" name="datahora_pedido" class="form-control" id="datahora_pedido" 
                        value="<?php echo date('Y-m-d\TH:i', strtotime($row['data_pedido'])); ?>" required>
                </div>

                <div class="form-group">

                    <label for="status" class="form-label">Status do Pedido</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Ativo" <?php if ($row['status'] == 'Ativo') echo 'selected'; ?>>Ativo</option>
                        <option value="Inativo" <?php if ($row['status'] == 'Inativo') echo 'selected'; ?>>Inativo</option>
                        <option value="Suspenso" <?php if ($row['status'] == 'Suspenso') echo 'selected'; ?>>Suspenso</option>
                    </select>
                </div>

                <div class="form-group">

                    <label for="valor_total" class="form-label">Valor Total</label>
                    <input type="text" name="valor_total" class="form-control" id="valor_total" value="<?php echo $row['valor_total']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="funcionario_responsavel" class="form-label">Funcionário Responsável</label>
                    <select class="form-control" id="funcionario_responsavel" name="funcionario_id" required>
                        <?php foreach ($result_funcionarios as $funcionario) { ?>
                            <option value="<?= $funcionario['funcionario_id'] ?>" <?php if ($funcionario['funcionario_id'] == $row['funcionario_id']) echo 'selected'; ?>>
                                <?= $funcionario['nome'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar Pedido</button>
                </form>
                        </main>
        </div>
    </div>
</body>

</html>