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
    <title>SysRecycling</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="jumbotron">
  <div class="container">
    <h1>SysRecycling</h1>
    <p>Bem vindo <?=$_SESSION['nome']?></p>
    <p>
      <div class="btn-group">
        <a class="btn btn-primary btn-lg" role="button" href="clientes.php">
          <i class="fa fa-users fa-lg"></i> Clientes
        </a>
      </div>

      <div class="btn-group">
        <a class="btn btn-primary btn-lg" role="button" href="material.php">
          <i class="fa fa-inbox fa-lg"></i>  Material
        </a>
      </div>

      <div class="btn-group">
        <a class="btn btn-primary btn-lg" role="button" href="movimentacao.php">
          <i class="fa fa-retweet fa-lg"></i>  Movimentações
        </a>
      </div>

      <div class="btn-group">
        <a class="btn btn-primary btn-lg" role="button" href="usuarios.php">
          <i class="fa fa-user fa-lg"></i>  Usuários
        </a>
      </div>

      <div class="btn-group">
        <button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-bar-chart-o fa-lg"></i>  Relatórios <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
          <li><a href="rel-clientes.php">Clientes</a></li>
          <li><a href="rel-material.php">Materiais</a></li>
          <li><a href="rel-movimentacao.php">Movimentações</a></li>
        </ul>

    </p>
  </div>
</div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
