<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$q ='';
if(isset($_GET['q'])){
  $q = strtolower($_GET['q']);
}
$sql = "SELECT c.idcliente, c.nome, c.telefone, c.endereco, c.status, tc.tipocliente From cliente as c
inner join tipo_cliente as tc On tc.idtipo_cliente = c.idtipo_cliente";
if($q != ''){
  $sql .= " WHERE c.nome LIKE '$q%'";
}
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clientes</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-users"></i> Clientes</h1>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Clientes</h3>
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
        <th>Id</th>
        <th>Status</th>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Tipo Cliente</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
        while($linha=$res->fetch(PDO::FETCH_ASSOC)){
          ?>

        <td><?php echo $linha['idcliente']; ?></td>
        <td>
          <?php
          if($linha['status'] == 1){
          ?>
          <span class="label label-success">ativo</span>
        <?php }else{ ?>
          <span class="label label-warning">inativo</span>
        <?php } ?>
        </td>
        <td><?php echo $linha['nome']; ?></td>
        <td class="telefone"><?php echo $linha['telefone']; ?></td>
        <td><?php echo $linha['tipocliente'] ?>
        </td>
        <td>
          <a href="clientes-editar.php?idcliente=<?php echo $linha['idcliente']; ?>" title="Editar cliente"><i class="fa fa-edit fa-lg"></i></a>
          <a href="clientes-apagar.php?idcliente=<?php echo $linha['idcliente']; ?>" title="Remover cliente"><i class="fa fa-times fa-lg"></i></a>
          <a href="venda-nova.php?idcliente=<?php echo $linha['idcliente']; ?>" title="Nova Venda"><i class="fa fa-share fa-lg"></i></a>
        </td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>
<script src="./lib/jquery.mask.js"></script>
  <script>
  $(document).ready(function() {
    $('.telefone').mask('(00) 0 0000-0000');
});
</script>

  </body>
</html>
