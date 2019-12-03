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
  idusuario, nome, email, status
From usuario";

if ($q != '') {
  $sql .= " Where (LOWER(nome) Like '%$q%') OR (LOWER(email) Like '%$q%')";
}

$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuários</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-user"></i> Usuários</h1>
</div>

<div class="panel panel-default">
  <div class="panel-heading clearfix">
    <h3 class="panel-title pull-left">Usuários</h3>
    
    <div class="btn-group pull-right">
      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-bars fa-lg"></i>
      </button>
      <ul class="dropdown-menu slidedown">
        <li>
            <a href="usuarios-cadastrar.php">
                <i class="fa fa-plus fa-fw"></i> Novo usuário
            </a>
        </li>
      </ul>
    </div>
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
        <th>Nome</th>
        <th>Email</th>
        <th></th>
      </tr>
    </thead>
    <tbody>

<?php
while ( $linha = $res->fetch(PDO::FETCH_ASSOC) ) {
?>
      <tr>
        <td><?= $linha['idusuario'] ?></td>
        <td>
<?php if ($linha['status'] == CATEGORIA_ATIVO) { ?>
          <span class="label label-success">ativo</span>
<?php } else { ?>
          <span class="label label-warning">inativo</span>
<?php } ?>
        </td>
        <td><?= $linha['nome'] ?></td>
        <td><?= $linha['email'] ?></td>
        <td>
            <a href="usuarios-editar.php?idusuario=<?= $linha['idusuario'] ?>" title="Editar usuário"><i class="fa fa-edit fa-lg"></i></a>
            <a href="usuarios-senha.php?idusuario=<?= $linha['idusuario'] ?>" title="Alterar senha"><i class="fa fa-lock fa-lg"></i></a>
        </td>
      </tr>
<?php
}
?>

    </tbody>
  </table>
</div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>