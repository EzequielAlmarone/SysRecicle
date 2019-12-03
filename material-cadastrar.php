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
$material = '';
$quantidade = '';
$idcategoria = 0;
$ativo = MATERIAL_ATIVO;

if ($_POST) {
  $material= $_POST['nome_material'];
  $quantidade = (int) $_POST['quantidade'];
  $idcategoria = (int) $_POST['idcategoria'];
  //echo "<br><br>";
  //var_dump($_POST['idcategoria']);
  if (isset($_POST['ativo'])){
    $ativo = MATERIAL_ATIVO;
  } else {
    $ativo = MATERIAL_INATIVO;
  }

  if (strlen($material) < 3) {
    $msg[] = 'Nome material deve conter no mínimo 3 caracteres';
  }elseif(existeMaterial($conn, $material)){
    $msg[] = 'Já existe um material cadastrado com esse nome';
  }
  if($idcategoria <= 0){
    $msg[] = 'Selecione uma categoria';
  }
  if (!$msg) {
    $sql = "Insert into material (nome_material, quantidade, status, idcategoria)
    Values (:nome_material, :quantidade, :status, :idcategoria)";
    $prep = $conn->prepare($sql);
    $prep->bindValue(':nome_material', $material);
    $prep->bindValue(':quantidade', $quantidade);
    $prep->bindValue(':status', $ativo);
    $prep->bindValue(':idcategoria', $idcategoria);
    $prep->execute();

    $idmaterial = $conn->lastInsertId();

    $url = "material-cadastrar.php?idmaterial=$idmaterial";
    javascriptAlertFim("Produto cadastrado", $url);
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./lib/select2.min.css">
  <style media="screen">
  .select2-selection.select2-selection--single{
    border-radius: 4px !important;
    height: 38px;
    border: 1px solid #cccccc;
    width: 100% !important;
  }
  .select2-results__option{
    color: #000000 !important;
  }
  .select2-selection__rendered{
    padding-top: 4px!important;
  }
  .select2-container--default.select2-selection--single.select2-selection__rendered{
      line-height: 35px!important;
  }
  .select2-selection__arrow{
    top: 8px!important;
  }
  .select2.select2-container.select2-container.select2-container.select2-container{
    width: 100% !important;
  }
  </style>
  <title>Cadastrar Material</title>

  <?php headCss(); ?>
</head>
<body>

  <?php include 'nav.php'; ?>

  <div class="container">

    <div class="page-header">
      <h1><i class="fa fa-inbox"></i> Cadastrar Material</h1>
    </div>

    <?php if ($msg) { msgHtml($msg); } ?>

    <form role="form" method="post" action="material-cadastrar.php">

      <div class="form-group">
        <label for="fdescricao">Nome Material</label>
        <input type="text" class="form-control" id="fdescricao" name="nome_material" placeholder="Nome material a cadastrar" value="<?= $material ?>" required>
      </div>

      <div class="form-group">
        <label for="fquantidade">Quantidade</label>
        <input type="number" class="form-control" id="fquantidade" name="quantidade" placeholder="Quantidade em Kg" value="<?= $quantidade ?>" required>
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
