<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();
if (isset($_GET['idusuario'])) {
    $idusuario = (int) $_GET['idusuario'];
} else {
    $idusuario = (int) $_POST['idusuario'];
}

$sql = "Select nome, email, senha, status From usuario
  Where idusuario = $idusuario";
$res = $conn->query($sql);
$resUsuario = $res->fetch(PDO::FETCH_ASSOC);
if (!$resUsuario) {
    javascriptAlertFim('Usuário inexistente', 'usuarios.php');
}

$nome = $resUsuario['nome'];
$email = $resUsuario['email'];
$ativo = $resUsuario['status'];

if ($_POST) {

  $nome = $_POST['nome'];
  $email = $_POST['email'];

  if (isset($_POST['ativo'])) {
    $ativo = USUARIO_ATIVO;
  } else {
    $ativo = USUARIO_INATIVO;
  }

  if (strlen($nome) < 3) {
    $msg[] = 'Nome de usuário deve conter no mínimo 3 caracteres';
  }
  if (strpos($email, '@') === false) {
    $msg[] = 'E-mail deve conter um @';
  }

  // Verificar email repetido
  $sql = "SELECT count(email) from usuario where idusuario  "  // dar continuidadeee....
  // A FAZER

  // Salvar no BD
  if (!$msg) {
    $sql = "Update usuario Set
    nome = :nome,
    email = :email,
    status = :ativo
    Where idusuario = :idusuario";

    $prep = $conn->prepare($sql);
    $prep->bindValue(':nome', $nome);
    $prep->bindValue(':email', $email);
    $prep->bindValue(':ativo', $ativo);
    $prep->bindValue(':idusuario', $idusuario);
    $prep->execute();

    // Salvar foto
    // A FAZER

    // Redirecionar usuario
    $url = "usuarios.php";
    javascriptAlertFim("Usuário salvo", $url);
    exit;
  }

}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Alterar cadastro de usuário</title>

<?php headCss(); ?>
    </head>
    <body>

<?php include 'nav.php'; ?>

<div class="container">

  <div class="page-header">
      <h1><i class="fa fa-user"></i> Editar usuário</h1>
  </div>

  <?php if ($msg) { msgHtml($msg); } ?>

  <form role="form" method="post" action="usuarios-editar.php">
  <input type="hidden" name="idusuario" value="<?= $idusuario ?>">
      <div class="form-group">
          <label for="fnome">Nome</label>
          <input type="text" class="form-control" id="fnome" name="nome" placeholder="Nome completo do usuário" value="<?= $nome ?>">
      </div>

      <div class="form-group">
          <label for="femail">Email</label>
          <input type="email" class="form-control" id="femail" name="email" placeholder="Endereço de email" value="<?= $email ?>">
      </div>

      <div class="form-group">
          <label for="ffoto">Foto do usuário</label>
          <input type="file" id="ffoto" name="foto">
          <p class="help-block">Somente foto em JPG.</p>
      </div>

      <div class="checkbox">
          <label for="fativo">
              <input type="checkbox" name="ativo" id="fativo"
              <?php if ($ativo == USUARIO_ATIVO) { ?>checked<?php } ?>
              > Usuário ativo
          </label>
      </div>

      <button type="submit" class="btn btn-primary">Salvar</button>
      <button type="reset" class="btn btn-danger">Cancelar</button>
  </form>

  </div>

</div>

<script src="./lib/jquery.js"></script>
<script src="./lib/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>
