<?php
require_once '../conexao.php';
require_once '../vendor/autoload.php';

use Mpdf\Mpdf;

$sql = "SELECT id_produto, nome_produto, preco, estoque FROM produtos";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$mpdf = new Mpdf();
$mpdf->SetTitle('Relatório de Produtos');

$html = '<h1>Relatório de Produtos</h1>';
$html .= '<table border="1" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                </tr>
            </thead>
            <tbody>';

foreach ($produtos as $produto) {
    $html .= '<tr>
                <td>' . $produto['id_produto'] . '</td>
                <td>' . $produto['nome_produto'] . '</td>
                <td>R$ ' . number_format($produto['preco'], 2, ',', '.') . '</td>
                <td>' . $produto['estoque'] . '</td>
              </tr>';
}

$html .= '</tbody></table>';

$mpdf = new Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
?>
