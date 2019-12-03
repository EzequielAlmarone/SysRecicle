<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras - Valor de venda x Valor pago</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-reorder"></i> Compras - Valor de venda x Valor pago</h1>
</div>

<div class="panel panel-default">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Cliente</th>
        <th>Data</th>
        <th>Valor de venda</th>
        <th>Valor pago</th>
        <th>Diferença</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{IDVENDA}</td>
        <td>{CLIENTE_NOME}</td>
        <td>{VENDA_DATA}</td>
        <td>{PRODUTO_PRECO}</td>
        <td>{VENDA_PRECO}</td>
        <td>{DIFERENCA}</td>
      </tr>
    </tbody>
  </table>
</div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>