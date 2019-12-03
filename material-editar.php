<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();
$idcategoria = 0;
$idmaterial = 0;

if ($_POST) {
  $idmaterial = (int) $_POST['idmaterial'];
} else {
  $idmaterial = (int) $_GET['idmaterial'];
}

$sql = "SELECT nome_material, quantidade, m.status, m.idcategoria
From material as m INNER JOIN categoria as c ON m.idcategoria = c.idcategoria
Where idmaterial = $idmaterial";
$res = $conn->query($sql);
$resmaterial = $res->fetch(PDO::FETCH_ASSOC);
if (!$resmaterial) {
  javascriptAlertFim('material inexistente', 'material.php');
}

$material = $resmaterial['nome_material'];
$quantidade = $resmaterial['quantidade'];
$ativo = $resmaterial['status'];
$idcategoria = $resmaterial['idcategoria'];

if ($_POST) {
  $idcategoria = $_POST['idcategoria'];
  $material = $_POST['nome_material'];
  $quantidade = $_POST['quantidade'];
  $ativo = $_POST['status'];

  if (isset($_POST['ativo'])) {
    $ativo = PRODUTO_ATIVO;
  } else {
    $ativo = PRODUTO_INATIVO;
  }

  if (strlen($material) < 3) {
    $msg[] = 'Material deve conter no mínimo 3 caracteres';
  }
  if($idcategoria <= 0){
    $msg[] = 'Deve selecionar uma categoria';
  }

  if (!$msg) {
    $sql = "Update material
    Set
      nome_material = :material,
      quantidade = :quantidade,
      status = :status,
      idcategoria = :idcategoria,
    Where idmaterial = :idmaterial";
    $prep = $conn->prepare($sql);
    $prep->bindValue(':material', $material);
    $prep->bindValue(':quantidade', $quantidade);
    $prep->bindValue(':status', $ativo);
    $prep->bindValue(':idcategoria', $idcategoria);
    $prep->bindValue(':idmaterial', $idmaterial);
    $prep->execute();

    $idmaterial = $conn->lastInsertId();

    $url = "material.php";
    javascriptAlertFim("Material alterado com sucesso", $url);
    exit;
  }

}

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar material</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<div class="container">

<div class="page-header">
  <h1><i class="fa fa-inbox"></i> Editar Material</h1>
</div>

<?php if ($msg) { msgHtml($msg); } ?>

<form role="form" method="post" action="material-cadastrar.php">

  <div class="form-group">
    <label for="fdescricao">Nome Material</label>
    <input type="text" class="form-control" id="fdescricao" name="nome_material" placeholder="Nome material a cadastrar" value="<?= $material ?>" required>
  </div>

  <div class="form-group">
    <label for="fquantidade">Quantidade</label>
    <input type="number" class="form-control" id="fquantidade" name="quantidade" placeholder="Quantidade" value="<?= $quantidade ?>" required>
  </div>

  <div class="form-group">
    <label for="fcategoria">Categoria</label>
    <select id="fcategoria" name="idcategoria" class="form-control categoria" required>
      <option value="0">Selecione a categoria</option>
      <?php
      $sql = "SELECT idcategoria, nome_categoria From categoria ORDER BY nome_categoria";
      $res = $conn->query($sql);
      while($linha = $res->fetch(PDO::FETCH_ASSOC)){
        ?>
        <option
        value = "<?=$linha['idcategoria']?>"
        <?php if($linha['idcategoria'] == $idcategoria) { ?> selected <?php } ?>
        ><?=$linha['nome_categoria']?></option>

      <?php } ?>
    </select>
  </div>

  <div class="checkbox">
    <label for="fativo">
      <input type="checkbox" name="ativo" id="fativo"
      <?php if ($ativo == MATERIAL_ATIVO) { ?>checked<?php } ?>
      > Material ativo
    </label>
  </div>

  <button type="submit" class="btn btn-primary">Cadastrar</button>
  <button type="reset" class="btn btn-danger">Cancelar</button>
</form>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>
<script src="./lib/select2.min.js"></script>
<script>
$(document).ready(function() {
$('.categoria').select2();
});
</script>

</body>
</html>
