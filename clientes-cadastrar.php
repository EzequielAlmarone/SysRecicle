<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();
$idtipocliente = -1;
$nome = '';
$endereco = '';
$telefone = '';
$fornecedor = FORNECEDOR_INATIVO;
$consumidor = CONSUMIDOR_INATIVO;
$ativo = CLIENTE_ATIVO;
if ($_POST) {
  // validar nome informado
  if(strlen($_POST['nome']) > 5){
    $nome = $_POST['nome'];
  }else{
    $msg[] = 'Nome deve conter no mínimo 5 caracteres';
  }
  $sql = "SELECT COUNT(idcliente) contador FROM cliente
  Where nome = '$nome'";
  $res = $conn->query($sql);
  $resContador = $res->fetch(PDO::FETCH_ASSOC);

  if($resContador['contador'] > 0){
    $msg[] = "Nome já existente, informe outro nome";
  }

  // Valida endereço informado
    $endereco = $_POST['endereco'];


  // numero telefone
  if(strlen($_POST['telefone']) == 15 ){
  $telefone = $_POST['telefone'];
  }else{
    $msg[] = "numero telefone informado invalido";
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

  // cliente ativo ou inativo
  if(isset($_POST['status'])){
    $ativo = CLIENTE_ATIVO;
  } else {
    $ativo = CLIENTE_INATIVO;
  }

  // tipo do Cliente
  if($consumidor == CONSUMIDOR_ATIVO && $fornecedor == FORNECEDOR_ATIVO){
    $idtipocliente = 3;
  } else if ($consumidor == CONSUMIDOR_ATIVO){
    $idtipocliente = 2;
  } else if($fornecedor == FORNECEDOR_ATIVO){
    $idtipocliente = 1;
  }else if($consumidor == CONSUMIDOR_INATIVO && $fornecedor == FORNECEDOR_INATIVO){
    $msg [] = "Selecione o tipo de cliente";
  }

  // Gravar no Banco de Dados
  if (!$msg) {
      $sql = "Insert into cliente (nome, endereco, telefone, status, idtipo_cliente)
      Values (:nome, :endereco, :telefone, :status, :idtipo_cliente)";
      $prep = $conn->prepare($sql);
      $prep->bindValue(':nome', $nome);
      $prep->bindValue(':endereco', $endereco);
      $prep->bindValue(':telefone', $telefone);
      $prep->bindValue(':status', $ativo);
      $prep->bindValue(':idtipo_cliente', $idtipocliente);
      $prep->execute();
      $idcliente = $conn->lastInsertId();
      $url = "clientes-editar.php?idcliente=$idcliente";
      javascriptAlertFim("Cadastro com sucesso", $url);
      exit;

    }
  }


?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar clientes</title>

    <?php headCss(); ?>
  </head>
  <body>

<?php include 'nav.php'; ?>

<section class="container">

<section class="page-header">
  <h1><i class="fa fa-users"></i> Cadastrar clientes</h1>
</section>

<?php if ($msg) { msgHtml($msg); } ?>

<form role="form" method="post" action="clientes-cadastrar.php">
  <section class="form-group">
    <label for="fnome">Nome</label>
    <input type="text" class="form-control" id="fnome" name="nome" placeholder="Nome cliente" value="">
  </section>
  <section class="form-group">
    <label for="fendereco">Endereço</label>
    <input type="text" class="form-control" id="fendereco" name="endereco" placeholder="Endereço cliente" value="">
  </section>
  <section class="form-group">
    <label for="ftelefone">Telefone</label>
    <input type="text" class="form-control telefone" id="ftelefone" name="telefone" placeholder="Telefone cliente Ex:(00)0 0000-0000" value="">
  </section>
  <section class="form-group">
    <label for="ftipocliente">Tipo de Cliente</label>
    <br>
      <input type="checkbox" name="fornecedor" id="ftipocliente"> Fornecedor <br>
      <input type="checkbox" name="consumidor" id="ftipocliente"> Consumidor
  </section>
  <section class="form-group">
      <label for="fativo">Status </label> <br>
        <input type="checkbox" name="status" id="fativo" checked> Cliente ativo

  </section>

  <button type="submit" class="btn btn-primary">Cadastrar</button>
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
