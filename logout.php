<?php
// Verifica se tem sessão aberta
if(session_status() !== PHP_SESSION_ACTIVE){
  //Inicia a sessão
  session_start();
}
// deleta os dados da sessão
session_unset();
// excluir a sessão
session_destroy();
// redireciona para login
header('location:login.php');
exit;
