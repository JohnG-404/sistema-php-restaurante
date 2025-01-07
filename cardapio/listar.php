<?php
require_once '../conexao.php';

try {
    $sql = "SELECT * FROM produtos";
    $stmt = $pdo->query($sql);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar produtos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            border: 1px solid #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .card-title {
            color: #007bff;
            font-weight: bold;
        }

        .btn-select {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        .btn-select:hover {
            background-color: #0056b3;
        }
    </style>
    <title>Cardápio</title>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Cardápio</h1>
        <form action="selecionar.php" method="post">
            <div class="row">
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($produto['nome_produto']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($produto['descricao']) ?></p>
                                <p><strong>Preço:</strong> R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="produtos[]" value="<?= $produto['id_produto'] ?>" id="produto<?= $produto['id_produto'] ?>">
                                    <label class="form-check-label" for="produto<?= $produto['id_produto'] ?>">Selecionar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn btn-select btn-block">Visualizar Seleção</button>
        </form>
        <div class="mt-3">
            <button class="btn btn-outline-secondary" onclick="history.back()">
                <i class="bi bi-arrow-left"></i> Voltar
            </button>
        </div>
    </div>
</body>
</html>
