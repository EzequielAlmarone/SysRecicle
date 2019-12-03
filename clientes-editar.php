<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();

// clientes-editar.php?idcliente=1

$idcliente = 0;
if ($_POST) {
  $idcliente = (int) $_POST['idcliente'];
}
else {
  $idcliente = (int) $_GET['idcliente'];
}
$sql = "SELECT nome, endereco, telefone, status, idtipo_cliente FROM cliente
Where idcliente = $idcliente";
$res = $conn->query($sql);
$resCliente = $res->fetch(PDO::FETCH_ASSOC);

if(!$idcliente){
  echo "<br><br><br>";
  var_dump($idcliente);
  javascriptAlertFim('Cliente inexistente','clientes.php');
}

$nome = $resCliente['nome'];
$endereco = $resCliente['endereco'];
$telefone = $resCliente['telefone'];
$ativo = $resCliente['status'];
$idtipocliente = $resCliente['idtipo_cliente'];

switch ($idtipocliente) {
  case '1':
    $fornecedor = FORNECEDOR_ATIVO;
    $consumidor = CONSUMIDOR_INATIVO;
    break;
  case '2':
    $fornecedor = FORNECEDOR_INATIVO;
    $consumidor = CONSUMIDOR_ATIVO;
    break;
  case '3':
    $fornecedor = FORNECEDOR_ATIVO;
    $consumidor = CONSUMIDOR_ATIVO;
    break;
}

if ($_POST) {
  // validar nome informado
  $idcliente = $_POST['idcliente'];
  echo "<br><br><br>";
  if(strlen($_POST['nome']) > 5){
    $nome = $_POST['nome'];
  }else{
    $msg[] = 'Nome deve conter no mínimo 5 caracteres';
  }
  // buscar no banco de dados
  $sql = "SELECT COUNT(idcliente) contador FROM cliente
  Where nome = '$nome' And idcliente != $idcliente";
  $res = $conn->query($sql);
  $resContador = $res->fetch(PDO::FETCH_ASSOC);

  if($resContador['contador'] > 0){
    $msg[] = "Nome já existente, informe outro nome";
  }

  // Valida endereço informado
    if(strlen($endereco = $_POST['endereco']) == 0){
      $msg[] = "Informe o endereço";
    }
  // validar numero telefone
  if(strlen($_POST['telefone']) == 15 ){
  $telefone = $_POST['telefone'];
  }else{
    $msg[] = "Numero telefone informado invalido";
  }

  // fornecedor ativo ou inativo
  if(isset($_POST['fornecedor'])){
    $fornecedor = FORNECEDOR_ATIVO;
  } else {
    $fornecedor = FORNECEDOR_INATIVO;
  }

  // consumidor ativo ou inativo
  if(isset($_POST['consumidor'])){
    $consumidor = CONSUMIDOR_ATIVO;
  } else {
    $consumidor = CONSUMIDOR_INATIVO;
  }
  //verificação do tipo de cliente
  if($consumidor == CONSUMIDOR_ATIVO && $fornecedor == FORNECEDOR_ATIVO){
    $idtipocliente = 3;
  } else if($consumidor == CONSUMIDOR_ATIVO){
    $idtipocliente = 2;
  } else if($fornecedor == FORNECEDOR_ATIVO){
    $idtipocliente = 1;
  } else if($consumidor == CONSUMIDOR_INATIVO && $fornecedor == FORNECEDOR_INATIVO){
    $msg[] = "Selecione o tipo de cliente";
  }

  // cliente ativo ou inativo
  if(isset($_POST['ativo'])){
    $ativo = CLIENTE_ATIVO;
  } else {
    $ativo = CLIENTE_INATIVO;
  }

  // Gravar no Banco de Dados
  if (!$msg) {
      $sql = "UPDATE cliente SET nome = :nome, endereco = :endereco, telefone = :telefone, status = :status, idtipo_cliente = :idtipo_cliente
      WHERE idcliente = :idcliente";
      $prep = $conn->prepare($sql);
      $prep->bindValue(':nome', $nome);
      $prep->bindValue(':endereco', $endereco);
      $prep->bindValue(':telefone', $telefone);
      $prep->bindValue(':status', $ativo);
      $prep->bindValue(':idtipo_cliente', $idtipocliente);
      $prep->bindValue(':idcliente', $idcliente);
      $prep->execute();
      javascriptAlertFim('Cliente atualizado com sucesso', 'clientes.php');
      exit;

    }
  }


?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar cliente</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<section class="container">

<section class="page-header">
  <h1><i class="fa fa-users"></i> Editar cliente</h1>
</section>

<?php if ($msg) { msgHtml($msg); } ?>

<form role="form" method="post" action="clientes-editar.php">

  <input name="idcliente" value="<?=$idcliente?>" type="hidden">

  <section class="form-group">
    <label for="fnome">Nome</label>
    <input type="text" class="form-control" id="fnome" name="nome" placeholder="Nome cliente" value="<?=$nome?>">
  </section>
  <section class="form-group">
    <label for="fendereco">Endereço</label>
    <input type="text" class="form-control" id="fendereco" name="endereco" placeholder="Endereço cliente" value="<?=$endereco?>">
  </section>
  <section class="form-group">
    <label for="ftelefone">Telefone</label>
    <input type="text" class="form-control telefone" id="ftelefone" name="telefone" placeholder="Telefone cliente Ex:(00) 00000-0000" value="<?=$telefone?>">
  </section>
  <section class="form-group">
    <label for="ftipocliente">Tipo de Cliente</label>
    <br>
      <input type="checkbox" name="fornecedor" id="ftipocliente" <?php if ($fornecedor == FORNECEDOR_ATIVO) { ?>checked<?php } ?>
      > Fornecedor <br>
      <input type="checkbox" name="consumidor" id="ftipocliente"
      <?php if ($consumidor == CONSUMIDOR_ATIVO) { ?>checked<?php } ?>
      > Consumidor
  </section>
  <section class="form-group">
      <label for="fativo">Status </label> <br>
        <input type="checkbox" name="ativo" id="fativo"
        <?php if ($ativo == CATEGORIA_ATIVO) {?> checked <?php } ?>
        > Cliente ativo

  </section>

  <button type="submit" class="btn btn-primary">Salvar</button>
  <button type="reset" class="btn btn-danger">Cancelar</button>
</form>

</section>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>
<script src="./lib/jquery.mask.js"></script>
  <script>
  $(document).ready(function() {
    $('.telefone').mask('(00) 00000-0000');
});
</script>

  </body>
</html>
