<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Sistema de Restaurante</title>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Sistema de Restaurante</h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <a href="clientes/listar.php" class="btn btn-primary btn-block">Gerenciar Clientes</a>
            </div>
            <div class="col-md-4">
                <a href="produtos/listar.php" class="btn btn-secondary btn-block">Gerenciar Produtos</a>
            </div>
            <div class="col-md-4">
                <a href="pedidos/listar.php" class="btn btn-success btn-block">Gerenciar Pedidos</a>
            </div>
        </div>
        <div class="container text-center mt-4">
        <div class="row">
            <div class="col align-self-center justify-content-center" >
                <a href="cardapio/listar.php" class="btn btn-dark btn-block">Cardapio</a>
            </div>
        </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <a href="relatorios/clientes_pdf.php" class="btn btn-info btn-block">Relatório de Clientes</a>
            </div>
            <div class="col-md-4">
                <a href="relatorios/produtos_pdf.php" class="btn btn-warning btn-block">Relatório de Produtos</a>
            </div>
            <div class="col-md-4">
                <a href="relatorios/pedidos_pdf.php" class="btn btn-danger btn-block">Relatório de Pedidos</a>
            </div>
            
        </div>
        
    </div>
</body>
</html>
