<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$periodo = 1;
if ( isset($_GET['periodo']) ) {
  $periodo = (int) $_GET['periodo'];
}

switch ($periodo) {
  case 2:
    $dataFinal = strtotime('today');
    $dataInicial = strtotime('-15 day', $dataFinal);
    break;

  case 3:
    $dataFinal = strtotime('today');
    $dataInicial = strtotime('-1 month', $dataFinal);
    break;

  case 4:
    $dataFinal = strtotime('today');
    $dataInicial = strtotime('-3 month', $dataFinal);
    break;

  case 5:
    $dataInicial = strtotime('1 jan'); // mktime(0, 0, 0, 1, 1);
    $dataFinal = strtotime('today');
    break;

  case 6:
    $dataInicial = mktime(0, 0, 0, -11, 1);
    $dataFinal = strtotime('1 jan'); // ('first day of this year') ; //mktime(0, 0, 0, 1, 1);
    break;

  default:
    $dataFinal = strtotime('-' . date('w') . ' day 00:00:00');
    $dataInicial = strtotime('-7 day', $dataFinal);
}

//echo date('c', $dataInicial) . " - " . date('c', $dataFinal);

//exit;
$sql = "SELECT
v.idcliente, c.nome as nomecliente,
sum(vi.qtd) as qtd, sum(vi.precopago * vi.qtd) precopago
FROM `venda` as v
Inner JOIN cliente as c ON (c.idcliente = v.idcliente)
Inner Join vendaitem as vi on (vi.idvenda = v.idvenda)
WHERE (v.data >= :dataInicial) AND (v.data < :dataFinal) AND (v.status = 1)
Group by v.idvenda";
$prep = $conn->prepare($sql);
$prep->bindValue(':dataInicial', date('c', $dataInicial));
$prep->bindValue(':dataFinal', date('c', $dataFinal));
$prep->execute();



?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras por cliente</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-reorder"></i> Compras por cliente</h1>
</div>

<div class="panel panel-default">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $precoTotal = 0;
      $qtdTotal = 0;
       while($linha = $prep->fetch(PDO::FETCH_ASSOC)){
         $precoVenda = (float)$linha['precopago'];
         $qtdVenda = (int)$linha['qtd'];

         $precoTotal += $precoVenda;
         $qtdTotal += $qtdVenda;


         ?>
      <tr>
        <td><?= $linha['idcliente']?></td>
        <td><?= $linha['nomecliente']?></td>
        <td>R$<?= number_format($precoVenda, 2, ',', '.')?></td>
      </tr>
    <?php } ?>

    </tbody>

  </table>
  <p><b>Valor total de Vendas:</b>R$ <u><?= number_format($precoTotal, 2, ',', '.')?></u> </p>
  <p><b>Quantidade de Venda Total:</b> <u><?=$qtdTotal?> </u></p>

</div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
