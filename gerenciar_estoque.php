<?php
include 'config.php';

// Processamento de CRUD para movimentações de estoque
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'];

    // Adicionar nova movimentação
    if ($acao === 'adicionar') {
        $produto_id = $_POST['produto_id'];
        $quantidade = (int)$_POST['quantidade'];
        $tipo = $_POST['tipo'];
        $data_movimentacao = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO estoque (produto_id, tipo_movimentacao, quantidade, data_movimentacao) 
                                VALUES (:produto_id, :tipo_movimentacao, :quantidade, :data_movimentacao)");
        $stmt->execute([ 
            ':produto_id' => $produto_id,
            ':tipo_movimentacao' => $tipo,
            ':quantidade' => $quantidade,
            ':data_movimentacao' => $data_movimentacao,
        ]);

        // Ajustar quantidade no estoque
        $ajuste = ($tipo === 'entrada' || $tipo === 'devolucao') ? $quantidade : -$quantidade;
        $stmt = $conn->prepare("UPDATE produtos SET quantidade_estoque = quantidade_estoque + :ajuste WHERE produto_id = :produto_id");
        $stmt->execute([':ajuste' => $ajuste, ':produto_id' => $produto_id]);
    }

    // Editar movimentação
    if ($acao === 'editar') {
        $estoque_id = $_POST['estoque_id'];
        $produto_id = $_POST['produto_id'];
        $quantidade = (int)$_POST['quantidade'];
        $tipo = $_POST['tipo'];

        // Recuperar movimentação original para ajustar o estoque
        $stmt = $conn->prepare("SELECT * FROM estoque WHERE estoque_id = :estoque_id");
        $stmt->execute([':estoque_id' => $estoque_id]);
        $movimentacao = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($movimentacao) {
            // Reverter o ajuste anterior
            $ajuste_original = ($movimentacao['tipo_movimentacao'] === 'entrada' || $movimentacao['tipo_movimentacao'] === 'devolucao') 
                ? -$movimentacao['quantidade'] 
                : $movimentacao['quantidade'];
            $stmt = $conn->prepare("UPDATE produtos SET quantidade_estoque = quantidade_estoque + :ajuste WHERE produto_id = :produto_id");
            $stmt->execute([':ajuste' => $ajuste_original, ':produto_id' => $movimentacao['produto_id']]);

            // Atualizar movimentação
            $stmt = $conn->prepare("UPDATE estoque SET produto_id = :produto_id, tipo_movimentacao = :tipo_movimentacao, quantidade = :quantidade WHERE estoque_id = :estoque_id");
            $stmt->execute([ 
                ':produto_id' => $produto_id,
                ':tipo_movimentacao' => $tipo,
                ':quantidade' => $quantidade,
                ':estoque_id' => $estoque_id,
            ]);

            // Aplicar novo ajuste
            $novo_ajuste = ($tipo === 'entrada' || $tipo === 'devolucao') ? $quantidade : -$quantidade;
            $stmt = $conn->prepare("UPDATE produtos SET quantidade_estoque = quantidade_estoque + :ajuste WHERE produto_id = :produto_id");
            $stmt->execute([':ajuste' => $novo_ajuste, ':produto_id' => $produto_id]);
        }
    }

    // Excluir movimentação
    if ($acao === 'excluir') {
        $estoque_id = $_POST['estoque_id'];

        // Recuperar movimentação para reverter ajuste
        $stmt = $conn->prepare("SELECT * FROM estoque WHERE estoque_id = :estoque_id");
        $stmt->execute([':estoque_id' => $estoque_id]);
        $movimentacao = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($movimentacao) {
            // Reverter ajuste
            $ajuste = ($movimentacao['tipo_movimentacao'] === 'entrada' || $movimentacao['tipo_movimentacao'] === 'devolucao') 
                ? -$movimentacao['quantidade'] 
                : $movimentacao['quantidade'];
            $stmt = $conn->prepare("UPDATE produtos SET quantidade_estoque = quantidade_estoque + :ajuste WHERE produto_id = :produto_id");
            $stmt->execute([':ajuste' => $ajuste, ':produto_id' => $movimentacao['produto_id']]);

            // Excluir movimentação
            $stmt = $conn->prepare("DELETE FROM estoque WHERE estoque_id = :estoque_id");
            $stmt->execute([':estoque_id' => $estoque_id]);
        }
    }
}

// Buscar dados para exibição
$queryProdutos = $conn->query("SELECT produto_id, nome FROM produtos");
$produtos = $queryProdutos->fetchAll(PDO::FETCH_ASSOC);

$queryMovimentacoes = $conn->query("SELECT e.estoque_id, e.tipo_movimentacao, e.quantidade, e.data_movimentacao, 
                                    p.nome AS produto_nome 
                                    FROM estoque e 
                                    JOIN produtos p ON e.produto_id = p.produto_id 
                                    ORDER BY e.data_movimentacao DESC");
$movimentacoes = $queryMovimentacoes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Movimentações de Estoque</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        /* Estilo do cabeçalho e botões */
        .btn-custom {
            background-color: #6a0dad; 
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #5b0c99;
        }

        .btn-custom:active {
            background-color: #4c0b88;
        }

        .btn-voltar {
            background-color: #6a0dad; 
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-voltar:hover {
            background-color: #5b0c99;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 15px;
        }

        h1, h2 {
            color: #333;
        }

        table {
            margin-top: 30px;
            border-collapse: collapse;
            width: 100%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #6a0dad;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e9e9e9;
        }

        .form-control {
            border-radius: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <button class="btn-voltar" onclick="window.location.href='estoque.php'">Voltar</button>

        <h1 class="my-4">Gerenciar Movimentações de Estoque</h1>

        <form method="POST" class="mb-4">
            <input type="hidden" name="acao" value="adicionar">
            <div class="form-group">
                <label for="produto_id">Produto:</label>
                <select name="produto_id" id="produto_id" class="form-control" required>
                    <?php foreach ($produtos as $produto): ?>
                        <option value="<?php echo $produto['produto_id']; ?>"><?php echo $produto['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="quantidade">Quantidade:</label>
                <input type="number" name="quantidade" id="quantidade" class="form-control" required min="1">
            </div>

            <div class="form-group">
                <label for="tipo">Tipo de Movimentação:</label>
                <select name="tipo" id="tipo" class="form-control" required>
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                    <option value="devolucao">Devolução</option>
                </select>
            </div>

            <button type="submit" class="btn-custom">Adicionar Movimentação</button>
        </form>

        <h2>Movimentações de Estoque</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movimentacoes as $movimentacao): ?>
                    <tr>
                        <td><?php echo $movimentacao['estoque_id']; ?></td>
                        <td><?php echo $movimentacao['produto_nome']; ?></td>
                        <td><?php echo ucfirst($movimentacao['tipo_movimentacao']); ?></td>
                        <td><?php echo $movimentacao['quantidade']; ?></td>
                        <td><?php echo $movimentacao['data_movimentacao']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
