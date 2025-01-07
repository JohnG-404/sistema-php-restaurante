<?php
require_once '../conexao.php';
require_once '../vendor/autoload.php';

use Mpdf\Mpdf;

// Consultando os pedidos e clientes
$sql = "SELECT pedidos.id_pedido, pedidos.data_pedido, clientes.nome 
        FROM pedidos 
        INNER JOIN clientes ON pedidos.id_cliente = clientes.id_cliente 
        ORDER BY pedidos.data_pedido DESC";
$stmt = $pdo->query($sql);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gerando o PDF
$mpdf = new Mpdf();
$mpdf->SetTitle('Relatório de Pedidos');

// Estilos para centralizar o texto
$html = '
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #000;
        text-align: center;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
</style>';

// Construção do conteúdo
$html .= '<h1>Relatório de Pedidos</h1>';
$html .= '<table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Produtos</th>
                </tr>
            </thead>
            <tbody>';

// Iterando sobre os pedidos
foreach ($pedidos as $pedido) {
    // Consultando os produtos do pedido
    $sqlItens = "SELECT produtos.nome_produto, itens_pedido.quantidade, itens_pedido.preco_unitario 
                 FROM itens_pedido 
                 INNER JOIN produtos ON itens_pedido.id_produto = produtos.id_produto 
                 WHERE itens_pedido.id_pedido = :id_pedido";
    $stmtItens = $pdo->prepare($sqlItens);
    $stmtItens->execute(['id_pedido' => $pedido['id_pedido']]);
    $itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

    // Construindo a lista de produtos
    $produtosHtml = '<ul>';
    foreach ($itens as $item) {
        $produtosHtml .= '<li>' . $item['nome_produto'] . ' - ' . $item['quantidade'] . ' x R$ ' . number_format($item['preco_unitario'], 2, ',', '.') . '</li>';
    }
    $produtosHtml .= '</ul>';

    // Adicionando os dados do pedido e produtos ao relatório
    $html .= '<tr>
                <td>' . $pedido['id_pedido'] . '</td>
                <td>' . date('d/m/Y H:i', strtotime($pedido['data_pedido'])) . '</td>
                <td>' . $pedido['nome'] . '</td>
                <td style="text-align: left;">' . $produtosHtml . '</td>
              </tr>';
}

$html .= '</tbody></table>';

// Gerando o PDF com o conteúdo HTML
$mpdf->WriteHTML($html);
$mpdf->Output();
?>
