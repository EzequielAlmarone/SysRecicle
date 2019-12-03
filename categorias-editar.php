<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();

$idcategoria = 0;
if ( isset($_GET['idcategoria']) ) {
  $idcategoria = (int) $_GET['idcategoria'];
} elseif ( isset($_POST['idcategoria']) ) {
  $idcategoria = (int) $_POST['idcategoria'];
}

$sql = "Select nome_categoria, status From categoria
Where idcategoria = $idcategoria";
$res = $conn->query($sql);
$resCategoria = $res->fetch(PDO::FETCH_ASSOC);
if (!$resCategoria) {
  javascriptAlertFim('Categoria inexistente', 'categorias.php');
}

$categoria = $resCategoria['nome_categoria'];
$ativo = $resCategoria['status'];

if ($_POST) {
  // receber dados do usuario
  $categoria = $_POST['categoria'];

  if ( isset($_POST['ativo']) ) {
    $ativo = CATEGORIA_ATIVO;
  } else {
    $ativo = CATEGORIA_INATIVO;
  }

  // validar os dados recebidos

  if (strlen($categoria) < 3) {

    echo "<br><br>";

    var_dump(strlen($categoria));
    $msg[] = 'Informe uma categoria com pelo menos 3 caracteres';
  }elseif( existeCategoria($conn, $categoria, $idcategoria)){
    $msg[] = 'Já existe uma categoria cadastrada com esse nome.';
  }


  // atualizar os dados recebidos no BD
  if (!$msg) {
    $sql = "Update categoria SET
    nome_categoria = :categoria, status = :ativo
    Where idcategoria = :idcategoria";
    $prep = $conn->prepare($sql);
    $prep->bindValue(':categoria', $categoria);
    $prep->bindValue(':ativo', $ativo);
    $prep->bindValue(':idcategoria', $idcategoria);
    $prep->execute();

    // mostrar mensagem para usuario
    javascriptAlertFim('Categoria atualizada', 'categorias.php');
  }

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Alterar categoria</title>

  <?php headCss(); ?>
</head>
<body>

  <?php include 'nav.php'; ?>

  <div class="container">

    <div class="page-header">
      <h1><i class="fa fa-cubes"></i> Editar categorias</h1>
    </div>

    <?php if ($msg) { msgHtml($msg); } ?>

    <form role="form" method="post" action="categorias-editar.php">
      <input type="hidden" name="idcategoria" value="<?= $idcategoria ?>">

      <div class="form-group">
        <label for="fcategoria">Categoria</label>
        <input type="text" class="form-control" id="fcategoria" name="categoria" placeholder="Nome da categoria" value="<?= $categoria ?>">
      </div>

      <div class="checkbox">
        <label for="fativo">
          <input type="checkbox" name="ativo" id="fativo"
          <?php if ($ativo == CATEGORIA_ATIVO) { ?>checked<?php } ?>
          > Categoria ativa
        </label>
      </div>

      <button type="submit" class="btn btn-primary">Salvar</button>
      <button type="reset" class="btn btn-danger">Cancelar</button>
    </form>

  </div>

  <script src="./lib/jquery.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
