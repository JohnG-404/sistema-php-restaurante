<?php
require_once '../conexao.php';

$sql = "SELECT * FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Produtos</title>
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
    <h1>Produtos</h1>
    <a href="inserir.php" class="btn btn-success mb-3">Novo Produto</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($produtos as $produto): ?>
            <tr>
                <td><?= $produto['id_produto'] ?></td>
                <td><?= $produto['nome_produto'] ?></td>
                <td><?= $produto['descricao'] ?></td>
                <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                <td><?= $produto['estoque'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $produto['id_produto'] ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="excluir.php?id=<?= $produto['id_produto'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
