<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();
$idcliente = 0;
$material = '';
$quantidade = 0;
$idcategoria = 0;
$ativo = MATERIAL_ATIVO;
if ($_POST) {
  $idcliente = $_POST['idcliente'];
  $idcategoria = $_POST['idcategoria'];
  $material = $_POST['nome_material'];
  $quantidade = (int) $_POST['quantidade'];
  $idcategoria = (int) $_POST['idcategoria'];
  //echo "<br><br>";
  //var_dump($_POST['idcategoria']);
  if (isset($_POST['ativo'])) {
    $ativo = MATERIAL_ATIVO;
  } else {
    $ativo = MATERIAL_INATIVO;
  }

  if (strlen($material) < 3) {
    $msg[] = 'Nome material deve conter no mínimo 3 caracteres';
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
  .select2-selection__rendered{
    padding-top: 4px!important;

  }
  .select2-selection__arrow{
    top: 8px!important;
  }
  .select2.select2-container.select2-container.select2-container.select2-container{
    width: 100% !important;
  }


  </style>
  <title>Saída Material</title>

  <?php headCss(); ?>
</head>
<body>

  <?php include 'nav.php'; ?>

  <div class="container">

    <div class="page-header">
      <h1><i class="fa fa-sign-out"></i> Saída Material</h1>
    </div>

    <?php if ($msg) { msgHtml($msg); } ?>

    <form role="form" method="post" action="movimentacao-entrada.php">

      <div class="form-group">
        <label for="fcliente">Nome Cliente</label>
        <select id="fcliente" name="idcliente" class="form-control select2" required>
          <option value="0">Selecione o Cliente</option>
          <?php
          $sql = "SELECT idcliente, nome From cliente as c INNER JOIN tipo_cliente as tc ON c.idtipo_cliente = tc.idtipo_cliente WHERE c.idtipo_cliente = 1 or c.idtipo_cliente = 3 ORDER BY nome";
          $res = $conn->query($sql);
          while($linha = $res->fetch(PDO::FETCH_ASSOC)){
            ?>
            <option
            value = "<?=$linha['idcliente']?>"
            <?php if($linha['idcliente'] == $idcliente) { ?> selected <?php } ?>
            ><?=$linha['nome']?></option>

          <?php } ?>
        </select>
      </div>
      <div class="row">
       <form class="" action="" method="post">
        <div class="col-md-6">
          <div class="form-group">
            <label for="fmaterial">Nome Material</label>
            <select id="fmaterial" name="idmaterial" class="form-control select2" required>
              <option value="0">Selecione o Material</option>
              <?php
              $sql = "SELECT idmaterial, nome_material From material";
              $res = $conn->query($sql);
              while($linha = $res->fetch(PDO::FETCH_ASSOC)){
                ?>
                <option
                value = "<?=$linha['idmaterial']?>"
                <?php if($linha['idmaterial'] == $idcliente) { ?> selected <?php } ?>
                ><?=$linha['nome_material']?></option>
              <?php } ?>
            </select>
          </div>

        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="fquantidade">Quantidade</label>
            <input type="number" class="form-control" id="fquantidade" name="quantidade" placeholder="Quantidade" value="<?= $quantidade ?>" required>
          </div>
        </div>
        <div class="col-md-2 col-md-offset-2">
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Adicionar</button>
          </div>
        </div>
        </form>
      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>id</th>
            <th>Nome Material</th>
            <th>Categoria</th>
            <th>Quantidade</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <?php  ?>
            <td><?php forench($_SESSION['idmaterial'] as $i);?></td>
            <td><?php $_SESSION['nome_material'] ?></td>
            <td><?php $_SESSION['categoria'] ?></td>
            <td><?php $_SESSION['quantidade'] ?></td>
            <td>
              <a href="" title="Remover Material"><i class="fa fa-times fa-lg"></i></a>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="fmotorista">Nome Motorista</label>
            <input type="text" class="form-control" id="fmotorista" name="motorista" placeholder="Informe o nome motorista" value="" required>
          </div>

        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="fplaca">Placa Veículo</label>
            <input type="text" class="form-control" id="fplaca" name="placa" placeholder="Informe a placa" value="" required>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="fdata">Data</label>
            <input type="date" class="form-control" id="fdata" name="data" required>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="fhora">Hora Entrada</label>
            <input type="time" class="form-control" id="fhora" name="horaEntrada" required>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="fhora">Hora Saída</label>
            <input type="datetime-local" class="form-control" id="fhora" name="horaSaida" required>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group">
            <label for="fbruto">Peso Bruto</label>
            <input type="text" class="form-control" id="fbruto" name="pbruto" placeholder="Informe o peso bruto" value="" required>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <label for="ftara">Peso Tara</label>
            <input type="text" class="form-control" id="ftara" name="ptara" placeholder="Informe o peso tara" value="" required>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group">
            <label for="fliquido">Peso Liquído</label>
            <input type="text" class="form-control" id="fliquido" name="pliquido" placeholder="Informe o peso liquído" value="" required>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="fobservacao">Observação</label>
            <textarea class="form-control" id="fobservacao" name="observacao" value="" required></textarea>
          </div>
        </div>
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
    $('.select2').select2();
  });
</script>

</body>
</html>
