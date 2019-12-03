<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msgOk = array();
$msgAviso = array();

if (!isset($_SESSION['idvenda'])) {
  header('location:vendas.php');
  exit;
}

$idvenda = $_SESSION['idvenda'];
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Produtos da venda</title>

    <?php headCss(); ?>
  </head>
  <body>
      
<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-shopping-cart"></i> Andamento da venda #<?php echo $idvenda; ?></h1>
</div>

<?php if ($msgOk) { msgHtml($msgOk, 'success'); } ?>
<?php if ($msgAviso) { msgHtml($msgAviso, 'warning'); } ?>

<form role="form" method="post" action="venda-produto.php">
  
  <input type="hidden" name="acao" value="1">
  
  <div class="panel panel-info">
    <div class="panel-heading">
      <h3 class="panel-title">Adicionar produto</h3>
    </div>

    <div class="panel-body">

      <div class="container-fluid">
        <div class="row">

          <div class="col-xs-12 col-sm-6 col-md-8">
            <div class="form-group">
              <label for="fidproduto">Produto</label>
              <select id="fidproduto" name="idproduto" class="form-control" required>
                <option value="">Selecione um produto</option>
              </select>
            </div>
          </div>

          <div class="col-xs-12 col-sm-3 col-md-2">
            <div class="form-group">
              <label for="fqtd">Quantidade</label>
              <input type="number" class="form-control" id="fqtd" value="0" name="qtd" min="1" required>
            </div>
          </div>

          <div class="col-xs-12 col-sm-3 col-md-2">
            <div class="form-group">
              <label for="fpreco">Preço unitário</label>
              <div class="input-group">
                <span class="input-group-addon">R$</span>
                <input type="text" class="form-control" id="fpreco" name="preco" required>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>

    <div class="panel-footer">
      <button type="submit" class="btn btn-primary">Inserir</button>
      <button type="reset" class="btn btn-danger">Limpar</button>
    </div>
  </div>
</form>
  
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">Produtos da venda</h3>
  </div>

  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Qtd.</th>
        <th>Produto</th>
        <th>Preço unitário</th>
        <th>Preço total</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{QTD}</td>
        <td>{PRODUTO}</td>
        <td>{PRECO_PAGO}</td>
        <td>{TOTAL}</td>
        <td><a href="venda-produto.php?acao=2&idproduto={IDPRODUTO}" title="Remover produto da venda"><i class="fa fa-times fa-lg"></i></a></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th colspan="2">Total da venda</th>
        <th>{VENDA_TOTAL}</th>
        <th></th>
      </tr>
    </tfoot>
  </table>
</div>
  
<form class="form-horizontal" method="post" action="venda-fechar.php">
<div class="panel panel-success">
  <div class="panel-heading">
    <h3 class="panel-title">Fechamento da venda</h3>
  </div>
  
  <div class="panel-body">
    
    <div class="form-group">
      <label for="fcliente" class="col-sm-2 control-label">Código:</label>
      <div class="col-sm-2">
        <p class="form-control-static"><?php echo $idvenda; ?></p>
      </div>
      
      <label for="fcliente" class="col-sm-2 control-label">Data:</label>
      <div class="col-sm-2">
          <p class="form-control-static">{VENDA_DATA}</p>
      </div>
      
      <label for="fcliente" class="col-sm-2 control-label">Total:</label>
      <div class="col-sm-2">
        <p class="form-control-static">{VENDA_TOTAL}</p>
      </div>
    </div>
    
    <div class="form-group">
      <label for="fcliente" class="col-sm-2 control-label">Cliente:</label>
      <div class="col-sm-4">
        <p class="form-control-static">{CLIENTE_NOME}</p>
      </div>
      
      <label for="fcliente" class="col-sm-2 control-label">CPF:</label>
      <div class="col-sm-4">
        <p class="form-control-static">{CLIENTE_CPF}</p>
      </div>
    </div>
    
    <div class="form-group">
      <label for="fcliente" class="col-sm-2 control-label">Vendedor:</label>
      <div class="col-sm-4">
        <p class="form-control-static">{VENDEDOR_NOME}</p>
      </div>
    </div>
    
  </div>
  
  <div class="panel-footer">
    <button type="submit" class="btn btn-success">Fechar venda</button>
  </div>
</div>
</form>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>