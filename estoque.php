<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="src/css/styles.css">
    <style>
        /* Estilo do botão de Gerenciar Estoque */
        .btn-gerenciar-estoque {
            background-color: #5a2a8c; /* Roxo escuro */
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-gerenciar-estoque:hover {
            background-color: #4b1d6a; /* Roxo mais escuro */
        }

        /* Estilo da tabela */
        table.table thead {
            background-color: #5a2a8c; /* Roxo escuro */
            color: white;
        }

        table.table tbody tr:nth-child(even) {
            background-color: #f9f9f9; /* Branco para linhas pares */
        }

        table.table tbody tr:nth-child(odd) {
            background-color: #ffffff; /* Branco para linhas ímpares */
        }

        table.table th, table.table td {
            vertical-align: middle;
        }

        /* Estilo de título */
        h2 {
            margin-top: 20px;
            font-size: 24px;
            font-weight: 600;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .btn-gerenciar-estoque {
                width: 100%;
                font-size: 18px;
            }
        }

        /* Ajustando o conteúdo principal */
        main {
            padding: 20px;
            margin-left: 240px; /* Mantendo a margem da sidebar */
        }

        /* Estilo da tabela */
        .table-bordered td, .table-bordered th {
            border: 1px solid #ddd;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral (sem alteração) -->
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
                </div>
            </nav>

            <!-- Conteúdo principal -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Controle de Estoque</h1>
                </div>

                <?php
                include 'config.php';

                // Busca o estoque atual dos produtos
                $queryEstoqueAtual = $conn->query("SELECT produto_id, nome, quantidade_estoque FROM produtos");
                $produtos = $queryEstoqueAtual->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <!-- Botão Gerenciar Estoque -->
                <nav>
                    <a href="gerenciar_estoque.php" class="btn-gerenciar-estoque">Gerenciar Estoque</a>
                </nav>

                <h2>Estoque Atual</h2>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Quantidade em Estoque</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td><?= $produto['produto_id'] ?></td>
                                <td><?= $produto['nome'] ?></td>
                                <td><?= $produto['quantidade_estoque'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="src/js/script.js"></script>
</body>

</html>
