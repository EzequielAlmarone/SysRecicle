<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$q ='';
if ( isset($_GET['q']) ) {
  $q = strtolower($_GET['q']);
}

$sql = "Select
  idcategoria, nome_categoria, status
From categoria";

if ($q != '') {
  $sql .= " Where LOWER(nome_categoria) Like '%$q%'";
}

$res = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categorias</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-cubes"></i> Categorias</h1>
</div>

<div class="panel panel-default">
  <div class="panel-heading">Categorias</div>
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
        <th>ID</th>
        <th>Status</th>
        <th>Categoria</th>
        <th></th>
      </tr>
    </thead>
    <tbody>

<?php
while ( $linha = $res->fetch(PDO::FETCH_ASSOC) ) {
?>
      <tr>
        <td><?= $linha['idcategoria'] ?></td>
        <td>
<?php if ($linha['status'] == CATEGORIA_ATIVO) { ?>
          <span class="label label-success">ativo</span>
<?php } else { ?>
          <span class="label label-warning">inativo</span>
<?php } ?>
        </td>
        <td><?= $linha['nome_categoria'] ?></td>
        <td>
          <a href="categorias-editar.php?idcategoria=<?= $linha['idcategoria'] ?>" title="Editar categoria"><i class="fa fa-edit fa-lg"></i></a>
          <a href="categorias-apagar.php?idcategoria=<?= $linha['idcategoria'] ?>" title="Remover categoria"><i class="fa fa-times fa-lg"></i></a>
        </td>
      </tr>
<?php } ?>

    </tbody>
  </table>
</div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
