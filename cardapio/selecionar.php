<?php
require_once '../conexao.php';

$produtosSelecionados = $_POST['produtos'] ?? [];

if (empty($produtosSelecionados)) {
    die("Nenhum produto foi selecionado.");
}

try {
    $placeholders = implode(',', array_fill(0, count($produtosSelecionados), '?'));
    $sql = "SELECT * FROM produtos WHERE id_produto IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($produtosSelecionados);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos selecionados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-bordered {
            border: 2px solid #007bff;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #007bff;
        }

        .btn-generate {
            background-color: #28a745;
            color: white;
        }

        .btn-generate:hover {
            background-color: #218838;
        }
    </style>
    <title>Produtos Selecionados</title>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Produtos Selecionados</h1>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                        <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form action="gerar_pdf.php" method="post">
            <?php foreach ($produtosSelecionados as $id): ?>
                <input type="hidden" name="produtos[]" value="<?= $id ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn btn-generate btn-block mt-4">Gerar PDF</button>
        </form>
        <div class="mt-3">
            <button class="btn btn-outline-secondary" onclick="history.back()">
                <i class="bi bi-arrow-left"></i> Voltar
            </button>
        </div>
    </div>
</body>
</html>

