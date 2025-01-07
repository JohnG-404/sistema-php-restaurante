<?php
require '../conexao.php';

$query = $pdo->query("SELECT * FROM clientes");
$clientes = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <title>Listar Clientes</title>
</head>
<body>
    
    <div class="container mt-4">
        <div class="mt-3 mb-4">
            <button class="btn btn-outline-secondary" onclick="history.back()">
                <i class="bi bi-arrow-left"></i> Voltar
            </button>
        </div>
        <h1>Clientes</h1>
        <a href="inserir.php" class="btn btn-primary mb-3">Adicionar Cliente</a>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>CEP</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= $cliente['id_cliente'] ?></td>
                    <td><?= $cliente['nome'] ?></td>
                    <td><?= $cliente['email'] ?></td>
                    <td><?= $cliente['telefone'] ?></td>
                    <td><?= $cliente['cep'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $cliente['id_cliente'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="excluir.php?id=<?= $cliente['id_cliente'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
