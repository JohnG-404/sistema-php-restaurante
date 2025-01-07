<?php
require '../conexao.php';
require '../vendor/autoload.php'; // Certifique-se de que o mPDF está instalado via Composer

use Mpdf\Mpdf;

$query = $pdo->query("SELECT * FROM clientes");
$clientes = $query->fetchAll(PDO::FETCH_ASSOC);

$html = "<h1>Relatório de Clientes</h1>";
$html .= "<table border='1' style='width: 100%; border-collapse: collapse;'>";
$html .= "<thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CEP</th>
            </tr>
          </thead>";
$html .= "<tbody>";
foreach ($clientes as $cliente) {
    $html .= "<tr>
                <td>{$cliente['id_cliente']}</td>
                <td>{$cliente['nome']}</td>
                <td>{$cliente['email']}</td>
                <td>{$cliente['telefone']}</td>
                <td>{$cliente['cep']}</td>
              </tr>";
}
$html .= "</tbody></table>";

$mpdf = new Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output();
?>
