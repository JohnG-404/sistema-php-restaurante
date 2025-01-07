<?php
require_once '../conexao.php';

if (!isset($_GET['id'])) {
    header('Location: listar.php');
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];

    $sql = "UPDATE produtos SET nome_produto = ?, descricao = ?, preco = ?, estoque = ? WHERE id_produto = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $descricao, $preco, $estoque, $id]);

    header('Location: listar.php');
    exit();
} else {
    $sql = "SELECT * FROM produtos WHERE id_produto = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        header('Location: listar.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
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
    <h1>Editar Produto</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="nome_produto" class="form-label">Nome do Produto</label>
            <input type="text" name="nome_produto" id="nome_produto" class="form-control" value="<?= $produto['nome_produto'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" rows="3"><?= $produto['descricao'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="preco" class="form-label">Preço</label>
            <input type="number" step="0.01" name="preco" id="preco" class="form-control" value="<?= $produto['preco'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="estoque" class="form-label">Estoque</label>
            <input type="number" name="estoque" id="estoque" class="form-control" value="<?= $produto['estoque'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div
