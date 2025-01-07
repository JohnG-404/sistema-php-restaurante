<?php
require '../conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: listar.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
$stmt->execute([$id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $stmt = $pdo->prepare("UPDATE clientes SET nome = ?, email = ?, telefone = ?, cep = ?, endereco = ?, bairro = ?, cidade = ?, estado = ? WHERE id_cliente = ?");
    $stmt->execute([$nome, $email, $telefone, $cep, $endereco, $bairro, $cidade, $estado, $id]);

    header("Location: listar.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Editar Cliente</title>
</head>
<body>
    <div class="container mt-4">
        <div class="mt-3 mb-4">
            <button class="btn btn-outline-secondary" onclick="history.back()">
                <i class="bi bi-arrow-left"></i> Voltar
            </button>
        </div>
        <h1>Editar Cliente</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?= $cliente['nome'] ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $cliente['email'] ?>" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" value="<?= $cliente['telefone'] ?>" required>
            </div>
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control" value="<?= $cliente['cep'] ?>" required>
            </div>
            <div class="form-group">
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" id="endereco" class="form-control" value="<?= $cliente['endereco'] ?>" required>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="<?= $cliente['bairro'] ?>" required>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" id="cidade" class="form-control" value="<?= $cliente['cidade'] ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado</label>
                <input type="text" name="estado" id="estado" class="form-control" value="<?= $cliente['estado'] ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
