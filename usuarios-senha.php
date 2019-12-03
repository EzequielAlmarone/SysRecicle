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

$sql = "Select nome From usuario
  Where idusuario = $idusuario";
$res = $conn->query($sql);
$resUsuario = $res->fetch(PDO::FETCH_ASSOC);
if (!$resUsuario) {
    javascriptAlertFim('Usuário inexistente', 'usuarios.php');
}

if ($_POST) {
  $senha = $_POST['senha'];
  $senha2 = $_POST['senha2'];

  if (strlen($senha) < 6) {
    $msg[] = 'Senha deve conter pelo menos 6 caracteres';
  }
  if ($senha != $senha2) {
    $msg[] = 'A confirmação da senha deve ser igual a senha informada';
  }
  $senha = hashSenha($senha);

  $sql = "UPDATE usuario set senha = :senha where idusuario = :idusuario";
  $prep = $conn->prepare($sql);
  $prep->bindValue('senha', $senha);
  $prep->bindValue('idusuario', $idusuario);
  $prep->execute();

  $url = "usuarios.php";
  javascriptAlertFim("Senha Atualizada com Sucesso", $url);
  exit;

}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Alterar senha de usuário</title>

        <?php headCss(); ?>
    </head>
    <body>

        <?php include 'nav.php'; ?>

        <div class="container">

            <div class="page-header">
                <h1><i class="fa fa-lock"></i> Alterar senha do usuário - <strong><?= $resUsuario['nome'] ?></strong> </h1>
            </div>

            <?php if ($msg) { msgHtml($msg); } ?>

            <form role="form" method="post" action="usuarios-senha.php">
        <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
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

                <button type="submit" class="btn btn-primary">Salvar</button>
                <button type="reset" class="btn btn-danger">Cancelar</button>
            </form>

        </div>

        <script src="./lib/jquery.js"></script>
        <script src="./lib/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>
