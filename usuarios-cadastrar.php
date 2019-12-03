<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

$msg = array();

$nome = '';
$email = '';
$senha = '';
$senha2 = '';

if ($_POST) {

  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $senha2 = $_POST['senha2'];


  if (strlen($nome) < 3) {
    $msg[] = 'Nome de usuário deve conter no mínimo 3 caracteres';
  }
  if (strpos($email, '@') === false) {
    $msg[] = 'E-mail deve conter um @';
  }

  // Verificar email repetido
  // A FAZER

  if (strlen($senha) < 6) {
    $msg[] = 'Senha deve conter pelo menos 6 caracteres';
  }
  if ($senha != $senha2) {
    $msg[] = 'A confirmação da senha deve ser igual a senha informada';
  }

  // Salvar no BD
  if (!$msg) {
    $senha = hashSenha($senha);
    $sql = "Insert into usuario (nome, email, senha)
    Values (:nome, :email, :senha)";

    $prep = $conn->prepare($sql);
    $prep->bindValue(':nome', $nome);
    $prep->bindValue(':email', $email);
    $prep->bindValue(':senha', $senha);
    $prep->execute();

    $idusuario = $conn->lastInsertId();
exit;
    // Redirecionar usuario
    $url = "usuarios-editar.php?idusuario=$idusuario";
    javascriptAlertFim("Usuário cadastrado", $url);
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
                <h1><i class="fa fa-user"></i> Cadastrar usuário</h1>
            </div>

            <?php if ($msg) { msgHtml($msg); } ?>

            <form role="form" method="post" enctype="multipart/form-data"  action="usuarios-cadastrar.php">
                <div class="form-group">
                    <label for="fnome">Nome</label>
                    <input type="text" class="form-control" id="fnome" name="nome" placeholder="Nome completo do usuário" value="<?= $nome ?>">
                </div>

                <div class="form-group">
                    <label for="femail">Email</label>
                    <input type="email" class="form-control" id="femail" name="email" placeholder="Endereço de email" value="<?= $email ?>">
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 col-xs-6">
                        <label for="fsenha">Senha</label>
                        <input type="password" class="form-control" id="fsenha" name="senha" placeholder="Senha do usuário">
                    </div>

                    <div class="form-group col-xs-6">
                        <label for="fsenha2">Repita a senha</label>
                        <input type="password" class="form-control" id="fsenha2" name="senha2" placeholder="Confirme a senha">
                    </div>
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

        <script src="./lib/jquery.js"></script>
        <script src="./lib/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>
