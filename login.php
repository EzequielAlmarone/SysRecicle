<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();

if($_POST){

  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $senha = hashSenha($senha);

  $sql = "SELECT idusuario,nome from usuario Where(email = :email) And (senha = :senha) And (status = :status)";
  $prep = $conn->prepare($sql);
  $prep->bindValue(':email', $email);
  $prep->bindValue(':senha', $senha);
  $prep->bindValue(':status', USUARIO_ATIVO);
  $prep->execute();

  $usuario = $prep->fetch(PDO::FETCH_ASSOC);
  if($usuario){
    if(session_status() !== PHP_SESSION_ACTIVE){
      session_start();
    }

    $_SESSION['idusuario'] = $usuario['idusuario'];
    $_SESSION['nome'] = $usuario['nome'];

    header('location:./');
    exit;

  }
  $msg[] = 'Email e/ou senha incorretos';

}


?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SysAterro Sanitário</title>

    <?php headCss(); ?>

    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
          }

          .container {
            max-width: 330px;
          }

          form { margin-bottom: 15px; }
    </style>
  </head>
  <body>

    <div class="container">

      <div class="row">
        <div class="col-xs-12">

          <h2 class="form-signin-heading">Faça seu login</h2>

          <form class="form-signin" role="form" method="post" action="login.php">
            <?php if ($msg) { msgHtml($msg); } ?>

            <div class="form-group">
              <label for="femail" class="sr-only">Email: </label>
              <input type="email" class="form-control" id="femail" name="email" placeholder="Endereço de e-mail" value="">
            </div>

            <div class="form-group">
              <label for="fsenha" class="sr-only">Senha: </label>
              <input type="password" class="form-control" id="fsenha" name="senha" placeholder="Senha">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Fazer login</button>
          </form>

        </div>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <div class="alert alert-info" role="alert">
            <strong>Email/Senha padrão:</strong> admin@gmail.com/marvel
          </div>
        </div>
      </div>

    </div>

    <script src="./lib/jquery.js"></script>
    <script src="./lib/bootstrap/js/bootstrap.min.js"></script>

  </body>
</html>
