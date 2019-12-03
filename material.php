<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$q ='';
$idcategoria = 0;

if ( isset($_GET['q']) ) {
  $q = strtolower($_GET['q']);
}
if (isset($_GET['idcategoria'])){
  $idcategoria = (int) $_GET['idcategoria'];
}

$sql = "SELECT
m.idmaterial, m.nome_material, m.status, c.nome_categoria
From material AS m Inner Join categoria AS c
On m.idcategoria = c.idcategoria";

$where = array();

if ($q != '') {
  $where [] = "(LOWER(material) Like '%$q%')";
}
if($idcategoria > 0){
  $where [] = "(m.idcategoria = $idcategoria)";
}

if($where){ // verifica se o array where salvo as mensagem.
  $sql .= " Where " . join(" AND ", $where);
}

$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Materiais</title>

  <?php headCss(); ?>
</head>
<body>

  <?php include 'nav.php'; ?>

  <div class="container">

    <div class="page-header">
      <h1><i class="fa fa-inbox"></i> Materiais</h1>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Materiais</h3>
      </div>
      <div class="panel-body">
        <form class="form-inline" role="form" method="get" action="">
          <div class="form-group">
            <label class="sr-only" for="fq">Pesquisa</label>
            <select class="form-control" name="idcategoria">
              <option value="0">Categoria</option>
              <?php categoriaOptions($conn, $idcategoria); ?>
            </select>
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
            <th>Material</th>
            <th></th>
          </tr>
        </thead>
        <tbody>

          <?php
          while ( $linha = $res->fetch(PDO::FETCH_ASSOC) ) {
            ?>

            <tr>
              <td><?= $linha['idmaterial'] ?></td>
              <td>
                <?php if ($linha['status'] == MATERIAL_ATIVO) { ?>
                  <span class="label label-success">ativo</span>
                <?php } else { ?>
                  <span class="label label-warning">inativo</span>
                <?php } ?>
                <td><?= $linha['nome_categoria'] ?></td>
                <td><?= $linha['nome_material'] ?></td>
                <td>
                  <a href="material-editar.php?idmaterial=<?= $linha['idmaterial']?>" title="Editar Material"><i class="fa fa-edit fa-lg"></i></a>
                  <a href="material-apagar.php?idmaterial=<?= $linha['idmaterial']?>" title="Remover Material"><i class="fa fa-times fa-lg"></i></a>
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
