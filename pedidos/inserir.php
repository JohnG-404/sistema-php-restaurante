<?php
require_once '../conexao.php';

// Busca clientes e produtos disponíveis no banco de dados
$clientes = $pdo->query("SELECT id_cliente, nome FROM clientes")->fetchAll(PDO::FETCH_ASSOC);
$produtos = $pdo->query("SELECT id_produto, nome_produto, preco, estoque FROM produtos")->fetchAll(PDO::FETCH_ASSOC);

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $produtos_selecionados = $_POST['produtos'];
    $quantidades = $_POST['quantidades'];
    $total = 0.00;
    $itens_validos = [];

    foreach ($produtos_selecionados as $index => $id_produto) {
        $quantidade = $quantidades[$index];
        $produto_info = $pdo->prepare("SELECT estoque, preco FROM produtos WHERE id_produto = ?");
        $produto_info->execute([$id_produto]);
        $produto = $produto_info->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            continue; // Ignorar produtos inválidos
        }

        if ($produto['estoque'] >= $quantidade) {
            $itens_validos[] = [
                'id_produto' => $id_produto,
                'quantidade' => $quantidade,
                'preco_unitario' => $produto['preco'],
            ];
            $total += $quantidade * $produto['preco'];
        } else {
            $erro = "O produto com ID {$id_produto} possui estoque insuficiente.";
            break;
        }
    }

    if (isset($erro)) {
        echo "<div class='alert alert-danger'>$erro</div>";
    } elseif (!empty($itens_validos)) {
        // Inserir o pedido
        $stmt = $pdo->prepare("INSERT INTO pedidos (id_cliente, total) VALUES (?, ?)");
        $stmt->execute([$id_cliente, $total]);
        $id_pedido = $pdo->lastInsertId();

        // Inserir itens do pedido e atualizar estoque
        foreach ($itens_validos as $item) {
            $pdo->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) 
                VALUES (?, ?, ?, ?)")
                ->execute([$id_pedido, $item['id_produto'], $item['quantidade'], $item['preco_unitario']]);

            $pdo->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id_produto = ?")
                ->execute([$item['quantidade'], $item['id_produto']]);
        }

        echo "<div class='alert alert-success'>Pedido realizado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-warning'>Nenhum item válido selecionado para o pedido.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Novo Pedido</title>
</head>
<body>
<div class="container mt-4">
    <h1>Inserir Novo Pedido</h1>
    <a href="listar.php" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
    <form method="POST">
        <div class="form-group">
            <label for="id_cliente">Cliente</label>
            <select name="id_cliente" id="id_cliente" class="form-control" required>
                <option value="">Selecione um cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?= $cliente['id_cliente'] ?>"><?= htmlspecialchars($cliente['nome']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div id="produtos-container">
            <h4>Produtos</h4>
            <?php foreach ($produtos as $produto): ?>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="produtos[]" value="<?= $produto['id_produto'] ?>">
                        <?= htmlspecialchars($produto['nome_produto']) ?> 
                        (R$ <?= number_format($produto['preco'], 2, ',', '.') ?>, 
                        <?= $produto['estoque'] ?> disponíveis)
                    </label>
                    <input type="number" name="quantidades[]" class="form-control mt-2" placeholder="Quantidade" min="1" max="<?= $produto['estoque'] ?>" disabled>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-success mt-3">Salvar Pedido</button>
    </form>
</div>
<script>
    // Habilitar ou desabilitar o campo de quantidade com base no checkbox
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const input = this.parentElement.nextElementSibling;
            input.disabled = !this.checked;
        });
    });
</script>
</body>
</html>
