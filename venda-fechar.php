<?php

require './protege.php';
require './config.php';
require './lib/funcoes.php';
require './lib/conexao.php';

// Pegar idvenda
if (!isset($_SESSION['idvenda'])) {
  header('location:vendas.php');
  exit;
}
$idvenda = $_SESSION['idvenda'];

