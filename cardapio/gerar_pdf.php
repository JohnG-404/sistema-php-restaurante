<?php
require_once '../vendor/autoload.php'; // Certifique-se de que o mPDF está corretamente configurado

// Verificar se os produtos foram enviados
if (!isset($_POST['produtos']) || empty($_POST['produtos'])) {
    echo "<script>alert('Nenhum produto selecionado!'); window.history.back();</script>";
    exit;
}

// Conectar ao banco de dados
require_once '../conexao.php';

$produtosSelecionados = $_POST['produtos'];
$placeholders = implode(',', array_fill(0, count($produtosSelecionados), '?'));

// Consultar os produtos selecionados
$sql = "SELECT nome_produto, descricao, preco FROM produtos WHERE id_produto IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$stmt->execute($produtosSelecionados);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gerar o PDF
$mpdf = new \Mpdf\Mpdf();

// Estilização do cardápio
$html = '
<style>
    body {
        font-family: "Georgia", serif;
        margin: 0;
        padding: 0;
        background-color: #fff9e6;
        color: #333;
    }
    h1 {
        text-align: center;
        color: #d2691e;
        font-size: 24px;
        margin-bottom: 20px;
        border-bottom: 2px solid #d2691e;
        padding-bottom: 10px;
    }
    .menu {
        width: 100%;
        margin: 0 auto;
    }
    .menu-item {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        margin: 10px 0;
        padding: 15px;
        background-color: #fff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
    .menu-item h2 {
        font-size: 18px;
        color: #d2691e;
        margin: 0;
    }
    .menu-item p {
        margin: 5px 0;
        font-size: 14px;
        color: #666;
    }
    .menu-item .price {
        font-weight: bold;
        font-size: 16px;
        color: #333;
        margin-top: 10px;
    }
</style>
<h1>Cardápio de Produtos</h1>
<div class="menu">';

foreach ($produtos as $produto) {
    $html .= '
    <div class="menu-item">
        <h2>' . htmlspecialchars($produto['nome_produto']) . '</h2>
        <p>' . htmlspecialchars($produto['descricao']) . '</p>
        <div class="price">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</div>
    </div>';
}

$html .= '</div>';

// Adicionar o conteúdo ao PDF
$mpdf->WriteHTML($html);

// Nome do arquivo para download
$nomeArquivo = 'cardapio_' . date('Ymd_His') . '.pdf';

// Forçar o download do arquivo PDF
$mpdf->Output($nomeArquivo, 'D');
