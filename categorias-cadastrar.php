<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();

$categoria = '';
$ativo = CATEGORIA_ATIVO;



if ($_POST) {
  $categoria = $_POST['categoria'];

  if (isset($_POST['ativo'])) {
    $ativo = CATEGORIA_ATIVO;
  } else {
    $ativo = CATEGORIA_INATIVO;
  }

  if (strlen($categoria) < 3) {
    $msg[] = 'Nome de categoria deve conter no mínimo 3 caracteres';
  }elseif( existeCategoria($conn, $categoria)){
    $msg[] = 'Já existe uma categoria cadastrada com esse nome';
  }

  if (!$msg) {
    $sql = "Insert into categoria (nome_categoria, status)
    Values (:categoria, :ativo)";
    $prep = $conn->prepare($sql);
    $prep->bindValue(':categoria', $categoria);
    $prep->bindValue(':ativo', $ativo);
    $prep->execute();

    $idcategoria = $conn->lastInsertId();

    $url = "categorias-cadastrar.php";
    javascriptAlertFim("Categoria cadastrada", $url);
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar categorias</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-cubes"></i> Cadastrar categorias</h1>
</div>

<?php if ($msg) { msgHtml($msg); } ?>

<form role="form" method="post" action="categorias-cadastrar.php">

  <div class="form-group">
    <label for="fcategoria">Categoria</label>
    <input type="text" class="form-control" id="fcategoria" name="categoria" placeholder="Nome da categoria"
    value="<?= $categoria ?>">
  </div>

  <div class="checkbox">
    <label for="fativo">
      <input type="checkbox" name="ativo" id="fativo"
      <?php if ($ativo == CATEGORIA_ATIVO) { ?>checked<?php } ?>>
      Categoria ativa
    </label>
  </div>

  <button type="submit" class="btn btn-primary">Cadastrar</button>
  <button type="reset" class="btn btn-danger">Cancelar</button>
</form>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
