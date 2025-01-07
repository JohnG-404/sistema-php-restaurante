<?php
require_once '../conexao.php';

// Buscar pedidos com informações do cliente e os itens do pedido
$query = "
    SELECT 
        pedidos.id_pedido, 
        clientes.nome AS nome_cliente, 
        pedidos.data_pedido, 
        pedidos.total 
    FROM pedidos 
    JOIN clientes ON pedidos.id_cliente = clientes.id_cliente
    ORDER BY pedidos.data_pedido DESC
";
$stmt = $pdo->query($query);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar itens de cada pedido
function getItensPedido($pdo, $id_pedido) {
    $stmt = $pdo->prepare("
        SELECT 
            produtos.nome_produto, 
            itens_pedido.quantidade, 
            itens_pedido.preco_unitario 
        FROM itens_pedido 
        JOIN produtos ON itens_pedido.id_produto = produtos.id_produto 
        WHERE itens_pedido.id_pedido = ?
    ");
    $stmt->execute([$id_pedido]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Listar Pedidos</title>
</head>
<body>
<div class="container mt-4">
    <h1>Listar Pedidos</h1>
    <a href="inserir.php" class="btn btn-primary mb-3">Novo Pedido</a>
    <a href="../index.php" class="btn btn-secondary mb-3">Voltar</a>
    
    <?php if (count($pedidos) > 0): ?>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Itens do Pedido</th>
                <th>Total</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido['id_pedido'] ?></td>
                    <td><?= htmlspecialchars($pedido['nome_cliente']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></td>
                    <td>
                        <ul>
                            <?php
                            $itens = getItensPedido($pdo, $pedido['id_pedido']);
                            foreach ($itens as $item): ?>
                                <li>
                                    <?= htmlspecialchars($item['nome_produto']) ?> 
                                    (<?= $item['quantidade'] ?> x 
                                    R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
                    <td>
                        <a href="detalhes.php?id=<?= $pedido['id_pedido'] ?>" class="btn btn-info btn-sm">Detalhes</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">Nenhum pedido encontrado.</div>
    <?php endif; ?>
</div>
</body>
</html>
