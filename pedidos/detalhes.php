<?php
require_once '../conexao.php';

if (!isset($_GET['id'])) {
    header('Location: listar.php');
    exit();
}

$id = $_GET['id'];

$sql = "SELECT p.id_pedido, p.data_pedido, c.nome, p.total 
        FROM pedidos p 
        INNER JOIN clientes c ON p.id_cliente = c.id_cliente 
        WHERE p.id_pedido = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    header('Location: listar.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
<div class="container my-4">
    <div class="mt-3 mb-4">
    <button class="btn btn-outline-secondary" onclick="history.back()">
        <i class="bi bi-arrow-left"></i> Voltar
    </button>
    </div>
    <h1>Detalhes do Pedido</h1>
    <p><strong>ID:</strong> <?= $pedido['id_pedido'] ?></p>
    <p><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($pedido['data_pedido'])) ?></p>
    <p><strong>Cliente:</strong> <?= $pedido['nome'] ?></p>
    <p><strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.') ?></p>
    <a href="listar.php" class="btn btn-secondary">Voltar</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
