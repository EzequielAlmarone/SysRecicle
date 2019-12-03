<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$q ='';
if(isset($_GET['q'])){
  $q =trim($_GET['q']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Movimentações</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-shopping-cart"></i> Movimentações</h1>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Movimentações</h3>
  </div>
  <div class="panel-body">
    <form class="form-inline" role="form" method="get" action="">
      <div class="form-group">
        <label class="sr-only" for="fq">Pesquisa</label>
        <input type="search" class="form-control" id="fq" name="q" placeholder="Pesquisa" value="<?php echo $q; ?>">
      </div>
      <button type="submit" class="btn btn-default">Pesquisar</button>
    </form>
  </div>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th></th>
        <th>Data</th>
        <th>Cliente</th>
        <th>Total</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{IDVENDA}</td>
        <td>
          <span class="label label-success">fechada</span>
          <span class="label label-warning">aberta</span>
        </td>
        <td>{DATA}</td>
        <td>{CLIENTE_NOME}</td>
        <td>{PRECO_TOTAL}</td>
        <td>
          <a href="venda-detalhes.php?idvenda={IDVENDA}" title="Detalhes da venda"><i class="fa fa-align-justify fa-lg"></i></a>
          <a href="venda-continuar.php?idvenda={IDVENDA}" title="Continuar venda"><i class="fa fa-play fa-lg"></i></a>
        </td>
      </tr>
    </tbody>
  </table>
</div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
